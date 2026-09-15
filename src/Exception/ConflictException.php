<?php

declare(strict_types=1);

namespace Simplia\Api3\Exception;

/** A 409: the shop's rules refused the request (`order-refused`, `voucher-locked`, `idempotency-key-reused`, …). */
final class ConflictException extends ApiProblemException {
}
