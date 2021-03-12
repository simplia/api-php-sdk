<?php

namespace Simplia\Api\Entity;

abstract class AbstractApiEntity {
    private string $fieldPrefix;
    private array $data;

    public function __construct(array $data, string $fieldPrefix = '') {
        $this->data = $data;
        $this->fieldPrefix = $fieldPrefix;
    }

    private function failOnMissingData(string $key): void {
        if (!array_key_exists($key, $this->data)) {
            throw new \RuntimeException('Field "' . $this->fieldPrefix . $key . '" was not loaded - add it to field list first');
        }
    }

    final protected function returnField(string $key, ?string $class = null) {
        $this->failOnMissingData($key);

        if ($class) {
            $data = $this->data[$key];
            if (!$data) {
                return null;
            }

            return new $class($data, $this->fieldPrefix . $key . '.');
        }

        return $this->data[$key];
    }

    final protected function returnFieldArray(string $key, string $class): array {
        $this->failOnMissingData($key);


        return array_map(fn(array $row) => new $class($row, $this->fieldPrefix . $key . '.'), $this->data[$key]);
    }
}
