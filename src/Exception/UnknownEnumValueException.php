<?php

declare(strict_types=1);

namespace Simplia\Api\Exception;

/**
 * The API answered a value of an enum-typed field that this version of the client does not know: the shop has
 * added it since the client was generated. Regenerate or upgrade `simplia/api`; the value itself is in `getValue()`.
 */
final class UnknownEnumValueException extends \UnexpectedValueException {
    /** @param class-string<\BackedEnum> $enum */
    public function __construct(private readonly string $field, private readonly string $value, private readonly string $enum) {
        parent::__construct(sprintf('Field "%s" carries "%s", which this client does not know as a %s; regenerate or upgrade simplia/api.', $field, $value, $enum));
    }

    public function getField(): string {
        return $this->field;
    }

    public function getValue(): string {
        return $this->value;
    }

    /** @return class-string<\BackedEnum> */
    public function getEnum(): string {
        return $this->enum;
    }
}
