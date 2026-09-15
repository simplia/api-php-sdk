<?php

declare(strict_types=1);

namespace Simplia\Api3\Exception;

/** A 429: the credential's quota is spent for the current window. Nothing was done; retry after `retryAfter()` seconds. */
final class RateLimitedException extends ApiProblemException {

    /** @param array<string, mixed>|null $body */
    public function __construct(int $status, ?string $type, ?string $title, ?string $detail, ?array $body, private readonly ?int $retryAfter) {
        parent::__construct($status, $type, $title, $detail, $body);
    }

    public function retryAfter(): ?int {
        return $this->retryAfter;
    }
}
