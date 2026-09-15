<?php

declare(strict_types=1);

namespace Simplia\Api3\Exception;

/**
 * Any non-2xx answer. `getType()` is the slug after `/api/3/errors/` (`not-found`, `order-refused`, …), stable
 * across releases; `getDetail()` is a sentence about this occurrence whose wording may change.
 */
class ApiProblemException extends \RuntimeException {

    /** @param array<string, mixed>|null $body the decoded problem document, null when the body was not JSON */
    public function __construct(
        private readonly int $status,
        private readonly ?string $type,
        private readonly ?string $title,
        private readonly ?string $detail,
        private readonly ?array $body,
    ) {
        parent::__construct(sprintf('API error HTTP %d%s%s', $status, $type !== null ? ' ' . $type : '', $detail !== null ? ': ' . $detail : ''), $status);
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function getDetail(): ?string {
        return $this->detail;
    }

    /** @return array<string, mixed>|null */
    public function getBody(): ?array {
        return $this->body;
    }
}
