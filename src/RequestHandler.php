<?php

namespace Simplia\Api;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class RequestHandler {
    private ClientInterface $client;

    private string $baseUri;
    private string $auth;
    private Psr17Factory $requestFactory;

    public function __construct(ClientInterface $client, string $host, string $auth) {
        $this->baseUri = 'https://' . $host . '/api/2/';
        $this->auth = $auth;
        $this->client = $client;
        $this->requestFactory = new Psr17Factory();
    }

    private function createUrl(string $path, array $query): string {
        $url = $this->baseUri . $path;
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $url;
    }

    private function send(RequestInterface $request): ResponseInterface {
        return $this->client->sendRequest($request
            ->withAddedHeader('Authorization', $this->auth)
        );
    }

    public function get(string $url, array $query): ?array {
        $response = $this->send($this->requestFactory->createRequest('GET', $this->createUrl($url, $query)));

        if ($response->getStatusCode() === 404) {
            return null;
        }

        $this->throwExceptionIfErrorResponse($response);

        return $this->decode($response);
    }

    private function throwExceptionIfErrorResponse(ResponseInterface $response): void {
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return;
        }

        try {
            $body = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            throw new RequestException('API error HTTP' . $response->getStatusCode() . "\n" . $response->getBody(), $body);
        } catch (\JsonException $exception) {
            throw new RequestException('API error HTTP' . $response->getStatusCode() . "\n" . $response->getBody(), null);
        }
    }

    public function request(string $method, string $url, array $query, array $body): ?array {
        $request = $this->requestFactory->createRequest($method, $this->createUrl($url, $query))
            ->withBody($this->requestFactory->createStream(json_encode($body, JSON_THROW_ON_ERROR)))
            ->withAddedHeader('content-type', 'application/json');
        $response = $this->send($request);

        if ($response->getStatusCode() === 404) {
            return null;
        }

        $this->throwExceptionIfErrorResponse($response);

        return $this->decode($response);
    }

    public function iterate(string $url, array $query, int $batchSize): \Generator {
        $query['page'] = 1;
        $query['limit'] = $batchSize;
        do {
            $request = $this->requestFactory->createRequest('GET', $this->createUrl($url, $query));
            $response = $this->send($request);

            $this->throwExceptionIfErrorResponse($response);

            $list = $this->decode($response);
            if (empty($list)) {
                break;
            }
            yield from $list;
            $query['page']++;
        } while ($response->hasHeader('Link'));

        yield from [];
    }

    private function decode(ResponseInterface $response): array {
        return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }
}
