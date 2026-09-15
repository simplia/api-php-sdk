<?php

declare(strict_types=1);

namespace Simplia\Api3;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Simplia\Api3\Exception\ApiProblemException;
use Simplia\Api3\Exception\ConflictException;
use Simplia\Api3\Exception\RateLimitedException;
use Simplia\Api3\Exception\ValidationException;

/**
 * The one HTTP seam of the client: builds `/api/3/` URLs, sends the credentials, follows keyset pages, turns a
 * problem document into a typed exception. Generated endpoints never touch PSR-7 themselves.
 */
final class RequestHandler {

    public const JSON = 'application/json';
    public const MERGE_PATCH = 'application/merge-patch+json';
    private const PROBLEM_PREFIX = '/api/3/errors/';

    private readonly string $baseUri;
    private readonly string $origin;
    private readonly Psr17Factory $factory;

    public function __construct(private readonly ClientInterface $client, string $host, private readonly string $authorization) {
        $this->origin = 'https://' . $host;
        $this->baseUri = $this->origin . '/api/3/';
        $this->factory = new Psr17Factory();
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>|null null for a 404
     */
    public function get(string $path, array $query): ?array {
        $response = $this->send0($this->factory->createRequest('GET', $this->url($path, $query)));
        if ($response->getStatusCode() === 404) {
            return null;
        }
        $this->failUnlessSuccess($response);

        return $this->decode($response);
    }

    /**
     * Every row of every page: the first page with `per_page`, then the `Link` header's `rel="next"` target,
     * resolved against the client's scheme and host (the server emits a bare path), until a page has none.
     *
     * @param array<string, mixed> $query
     * @return \Generator<int, array<string, mixed>>
     */
    public function iterate(string $path, array $query, int $perPage): \Generator {
        $query['per_page'] = $perPage;
        $url = $this->url($path, $query);
        while ($url !== null) {
            $response = $this->send0($this->factory->createRequest('GET', $url));
            $this->failUnlessSuccess($response);
            foreach ($this->decode($response) as $row) {
                if (!is_array($row)) {
                    throw new \UnexpectedValueException('A list answers records.');
                }
                yield $row;
            }
            $next = self::nextLink($response);
            $url = $next !== null ? $this->resolve($next) : null;
        }
    }

    /** @param array<string, mixed> $query */
    public function count(string $path, array $query): int {
        $query['per_page'] = 1;
        $query['with_total'] = 'true';
        $response = $this->send0($this->factory->createRequest('GET', $this->url($path, $query)));
        $this->failUnlessSuccess($response);
        if (!$response->hasHeader('X-Total-Count')) {
            throw new \RuntimeException('The API answered without X-Total-Count.');
        }

        return (int) $response->getHeaderLine('X-Total-Count');
    }

    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed>|\stdClass|null $body null sends no body (DELETE); an empty input is `(object) []`
     *        so it goes on the wire as `{}`, not `[]`
     * @return array<string, mixed>|null null for a 204
     */
    public function send(string $method, string $path, array $query, array|\stdClass|null $body, string $contentType = self::JSON, ?string $idempotencyKey = null): ?array {
        $request = $this->factory->createRequest($method, $this->url($path, $query));
        if ($body !== null) {
            $request = $request
                ->withBody($this->factory->createStream(json_encode($body, JSON_THROW_ON_ERROR)))
                ->withHeader('Content-Type', $contentType);
        }
        if ($method === 'POST') {
            $request = $request->withHeader('Idempotency-Key', $idempotencyKey ?? self::newIdempotencyKey());
        }
        $response = $this->send0($request);
        $this->failUnlessSuccess($response);
        if ($response->getStatusCode() === 204) {
            return null;
        }

        return $this->decode($response);
    }

    /** A random UUID version 4. */
    public static function newIdempotencyKey(): string {
        $bytes = random_bytes(16);
        $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
        $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    /** @param array<string, mixed> $query */
    private function url(string $path, array $query): string {
        $url = $this->baseUri . $path;
        if ($query !== []) {
            // ids[]=1&ids[]=2 as the API documents it, not ids[0]=1&ids[1]=2
            $url .= '?' . preg_replace('~%5B\d+%5D=~', '%5B%5D=', http_build_query($query, '', '&', PHP_QUERY_RFC3986));
        }

        return $url;
    }

    /**
     * The `Link` header's `rel="next"` target against the client's own scheme and host: the server emits an
     * absolute path (no scheme, no host), which a real PSR-18 client refuses as-is. An absolute `http(s)://` URL
     * (never seen live, kept for a future server change) passes through unchanged; anything else resolves
     * against `baseUri`.
     */
    private function resolve(string $target): string {
        if (str_starts_with($target, 'http://') || str_starts_with($target, 'https://')) {
            return $target;
        }
        if (str_starts_with($target, '/')) {
            return $this->origin . $target;
        }

        return $this->baseUri . $target;
    }

    private function send0(RequestInterface $request): ResponseInterface {
        return $this->client->sendRequest($request
            ->withHeader('Authorization', $this->authorization)
            ->withHeader('Accept', self::JSON));
    }

    /** @return array<mixed> */
    private function decode(ResponseInterface $response): array {
        $decoded = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($decoded)) {
            throw new \UnexpectedValueException('The API answered with something other than a JSON object or list.');
        }

        return $decoded;
    }

    private static function nextLink(ResponseInterface $response): ?string {
        foreach (explode(',', $response->getHeaderLine('Link')) as $link) {
            if (preg_match('~<([^>]+)>\s*;\s*rel="next"~', $link, $match) === 1) {
                return $match[1];
            }
        }

        return null;
    }

    private function failUnlessSuccess(ResponseInterface $response): void {
        $status = $response->getStatusCode();
        if ($status >= 200 && $status < 300) {
            return;
        }
        $body = json_decode((string) $response->getBody(), true);
        $body = is_array($body) ? $body : null;
        $type = null;
        if (is_string($body['type'] ?? null)) {
            $type = str_starts_with($body['type'], self::PROBLEM_PREFIX) ? substr($body['type'], strlen(self::PROBLEM_PREFIX)) : $body['type'];
        }
        $title = is_string($body['title'] ?? null) ? $body['title'] : null;
        $detail = is_string($body['detail'] ?? null) ? $body['detail'] : null;

        throw match ($status) {
            422 => new ValidationException($status, $type, $title, $detail, $body),
            409 => new ConflictException($status, $type, $title, $detail, $body),
            429 => new RateLimitedException($status, $type, $title, $detail, $body, $response->hasHeader('Retry-After') ? (int) $response->getHeaderLine('Retry-After') : null),
            default => new ApiProblemException($status, $type, $title, $detail, $body),
        };
    }
}
