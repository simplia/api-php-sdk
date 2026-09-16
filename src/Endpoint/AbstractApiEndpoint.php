<?php

declare(strict_types=1);

namespace Simplia\Api\Endpoint;

use Simplia\Api\FieldConfig\AbstractApiFieldConfig;
use Simplia\Api\Input\AbstractApiInput;
use Simplia\Api\Request\AbstractApiRequest;
use Simplia\Api\RequestHandler;

/** The operations of one resource; the generated subclass adds one method per operation. */
abstract class AbstractApiEndpoint {

    public function __construct(protected readonly RequestHandler $client) {
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>|null
     */
    protected function singleResult(string $path, array $query, AbstractApiFieldConfig $fields): ?array {
        return $this->client->get($path, self::withFields($query, $fields));
    }

    /**
     * @param array<string, mixed> $query
     * @return \Generator<int, array<string, mixed>>
     */
    protected function iterateList(string $path, array $query, AbstractApiRequest $request, AbstractApiFieldConfig $fields, int $perPage): \Generator {
        return $this->client->iterate($path, self::withFields(array_merge($query, $request->toArray()), $fields), $perPage);
    }

    /** @param array<string, mixed> $query */
    protected function countList(string $path, array $query, AbstractApiRequest $request): int {
        return $this->client->count($path, array_merge($query, $request->toArray()));
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>|null
     */
    protected function request(string $method, string $path, array $query, ?AbstractApiInput $input, ?AbstractApiFieldConfig $fields, string $contentType = RequestHandler::JSON, ?string $idempotencyKey = null): ?array {
        $input?->assertComplete();
        $body = $input?->toArray();
        if ($body === []) {
            // An input with nothing set must go on the wire as `{}`, not `[]` — RFC 7396 treats a non-object
            // merge-patch body as replacing the whole target.
            $body = (object) [];
        }

        return $this->client->send($method, $path, self::withFields($query, $fields), $body, $contentType, $idempotencyKey);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    private static function withFields(array $query, ?AbstractApiFieldConfig $fields): array {
        if ($fields !== null && $fields->toArray() !== []) {
            $query['fields'] = $fields->toQueryValue();
        }

        return $query;
    }
}
