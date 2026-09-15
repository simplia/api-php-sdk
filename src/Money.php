<?php

declare(strict_types=1);

namespace Simplia\Api3;

/**
 * An amount of money as the API carries it: a decimal string and the ISO 4217 code. Never a float.
 */
final class Money {

    public function __construct(public readonly string $amount, public readonly string $currency) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self {
        if (!is_string($data['amount'] ?? null) || !is_string($data['currency'] ?? null)) {
            throw new \UnexpectedValueException('A money value carries a string amount and a currency code.');
        }

        return new self($data['amount'], $data['currency']);
    }

    /** @return array{amount: string, currency: string} */
    public function toArray(): array {
        return ['amount' => $this->amount, 'currency' => $this->currency];
    }
}
