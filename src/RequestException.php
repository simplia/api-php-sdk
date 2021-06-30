<?php

namespace Simplia\Api;

class RequestException extends \RuntimeException {
    private ?array $response;

    public function __construct(string $message, ?array $response, int $code = 0, \Throwable $previous = null) {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): ?array {
        return $this->response;
    }

}
