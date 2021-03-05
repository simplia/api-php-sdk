<?php

namespace Simplia\Api\Request;

abstract class AbstractApiRequest {
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
