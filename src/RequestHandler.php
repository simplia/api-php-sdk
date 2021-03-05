<?php

namespace Simplia\Api;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

final class RequestHandler {
    private Client $client;

    public function __construct(string $host, string $username, string $password) {
        $this->client = new Client([
            'base_uri' => 'https://' . $host . '/api/2/',
            'auth' => [$username, $password],
            'headers' => [
                'Accept-Encoding' => 'gzip',
                'Accept' => 'application/gzip',
            ],
        ]);
    }

    public function get(string $url, array $query): ?array {
        $response = $this->client->get($url, [
            RequestOptions::QUERY => $query,
            RequestOptions::HTTP_ERRORS => false,
        ]);

        if ($response->getStatusCode() === 404) {
            return null;
        }

        $status = $response->getStatusCode();
        if ($status < 200 || $status > 299) {
            throw new \RuntimeException('API error HTTP' . $response->getStatusCode());
        }

        return $this->decode($response);
    }

    public function request(string $method, string $url, array $query, array $body): ?array {
        $response = $this->client->request($method, $url, [
            RequestOptions::QUERY => $query,
            RequestOptions::JSON => $body,
            RequestOptions::HTTP_ERRORS => false,
        ]);

        if ($response->getStatusCode() === 404) {
            return null;
        }

        $status = $response->getStatusCode();
        if ($status < 200 || $status > 299) {
            throw new \RuntimeException('API error HTTP' . $response->getStatusCode());
        }

        return $this->decode($response);
    }

    public function iterate(string $url, array $query, int $batchSize): \Generator {
        $query['page'] = 1;
        $query['limit'] = $batchSize;
        do {
            $response = $this->client->get($url, [
                RequestOptions::QUERY => $query,
            ]);

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
