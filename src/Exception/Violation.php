<?php

declare(strict_types=1);

namespace Simplia\Api\Exception;

/** One rejected value of a 422 answer. */
final class Violation {

    public function __construct(public readonly string $propertyPath, public readonly string $message, public readonly ?string $code) {
    }
}
