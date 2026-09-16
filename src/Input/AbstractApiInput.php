<?php

declare(strict_types=1);

namespace Simplia\Api\Input;

use Simplia\Api\Money;

/** The body of one write: the required properties arrive through the generated constructor, the optional ones through a set…() each. Only what was given is sent. */
abstract class AbstractApiInput implements \Countable {

    /** @var array<string, mixed> */
    protected array $params = [];

    /** @return array<string, mixed> */
    public function toArray(): array {
        return self::export($this->params);
    }

    public function count(): int {
        return count($this->params);
    }

    /**
     * @param list<mixed> $values
     * @param class-string $class
     */
    protected static function validateArray(array $values, string $class): void {
        foreach ($values as $value) {
            if (!$value instanceof $class) {
                throw new \InvalidArgumentException('Expected a list of ' . $class . '.');
            }
        }
    }

    /**
     * @param array<array-key, mixed> $values
     * @return array<array-key, mixed>
     */
    private static function export(array $values): array {
        foreach ($values as $key => $value) {
            if ($value instanceof self) {
                // A nested input with nothing set exports as `{}`, not `[]` — RFC 7396 treats a non-object
                // merge-patch body as replacing the whole target.
                $exported = $value->toArray();
                $values[$key] = $exported === [] ? (object) [] : $exported;
            } elseif ($value instanceof Money) {
                $values[$key] = $value->toArray();
            } elseif (is_array($value)) {
                $values[$key] = self::export($value);
            }
        }

        return $values;
    }
}
