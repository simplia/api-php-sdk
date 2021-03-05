<?php

namespace Simplia\Api\Endpoint;

use Simplia\Api\FieldConfig\AbstractFieldConfig;
use Simplia\Api\Input\AbstractApiInput;
use Simplia\Api\Request\AbstractApiRequest;
use Simplia\Api\RequestHandler;

abstract class AbstractEndpoint {
    protected RequestHandler $client;

    public function __construct(RequestHandler $client) {
        $this->client = $client;
    }

    protected function singleResult(string $path, array $query, AbstractFieldConfig $fieldConfig): ?array {
        $fields = $fieldConfig->toArray();
        if (!empty($fields)) {
            $query['fields'] = implode(',', $fields);
        }

        return $this->client->get($path, $query);
    }

    protected function request(string $method, string $path, array $query, ?AbstractApiInput $input, ?AbstractFieldConfig $fieldConfig): ?array {
        if ($fieldConfig) {
            $fields = $fieldConfig->toArray();
            if (!empty($fields)) {
                $query['fields'] = implode(',', $fields);
            }
        }

        return $this->client->request($method, $path, $query, $input ? $input->toArray() : []);
    }

    protected function iterateList(string $path, array $query, AbstractApiRequest $request, AbstractFieldConfig $fieldConfig, int $batchSize): \Generator {
        return $this->client->iterate($path, $this->createQuery($query, $request, $fieldConfig), $batchSize);
    }

    private function createQuery(array $query, AbstractApiRequest $request, AbstractFieldConfig $fieldConfig): array {
        $query = array_merge($query, $request->toArray());
        $fields = $fieldConfig->toArray();
        if (!empty($fields)) {
            $query['fields'] = implode(',', $fields);
        }

        return $query;
    }
}
