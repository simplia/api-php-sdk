<?php

namespace Simplia\Api\Input;

use Countable;

abstract class AbstractApiInput implements Countable {
    protected array $params = [];

    public function toArray(): array {
        foreach ($this->params as &$param) {
            if (is_array($param)) {
                foreach ($param as &$value) {
                    if ($value instanceof AbstractApiInput) {
                        $value = $value->toArray();
                    }
                }
            }
        }

        return $this->params;
    }

    /**
     * @return static
     */
    public static function create() {
        return new static();
    }

    protected static function validateArray(array $values, string $class): void {
        foreach ($values as $value) {
            if (!is_object($value) || get_class($value) !== $class) {
                throw new \RuntimeException('Expected value of type ' . $class);
            }
        }
    }

    public function count(): int {
        return count($this->params);
    }

}
