<?php

namespace Simplia\Api\Input;

abstract class AbstractApiInput {
    protected array $params = [];

    public function toArray(): array {
        return $this->params;
    }

    /**
     * @return static
     */
    public static function create() {
        return new static();
    }
}
