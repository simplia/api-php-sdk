<?php

declare(strict_types=1);

namespace Simplia\Api\Input;

use Simplia\Api\Exception\IncompleteInputException;
use Simplia\Api\Money;

/**
 * The body of one write, built in steps: `create()`, then a `set…()` per property in any order. Only what was set is
 * sent. The generated subclass lists the properties its schema requires in REQUIRED; an endpoint checks them
 * (`assertComplete()`) before building the request.
 */
abstract class AbstractApiInput implements \Countable {

    /**
     * Wire name => setter, for every property the schema requires; empty here and on every PATCH body.
     * @var array<string, string>
     */
    public const REQUIRED = [];

    /** @var array<string, mixed> */
    protected array $params = [];

    final public function __construct() {
    }

    public static function create(): static {
        return new static();
    }

    /** @return array<string, mixed> */
    public function toArray(): array {
        return self::export($this->params);
    }

    public function count(): int {
        return count($this->params);
    }

    /**
     * Throws when a required property of this input, or of any input nested in it, is absent or null. Every endpoint
     * calls it before building the request; call it yourself to check an input in a test.
     *
     * @throws IncompleteInputException
     */
    public function assertComplete(): void {
        $missing = [];
        $setters = [];
        $this->collectMissing('', $missing, $setters);
        if ($missing !== []) {
            throw new IncompleteInputException(static::class, $missing, $setters);
        }
    }

    /**
     * @param list<string> $missing
     * @param list<string> $setters
     */
    private function collectMissing(string $prefix, array &$missing, array &$setters): void {
        foreach (static::REQUIRED as $wire => $setter) {
            if (!array_key_exists($wire, $this->params) || $this->params[$wire] === null) {
                $missing[] = $prefix . $wire;
                $setters[] = $setter . '()' . ($prefix === '' ? '' : ' on ' . (new \ReflectionClass($this))->getShortName());
            }
        }
        foreach ($this->params as $wire => $value) {
            if ($value instanceof self) {
                $value->collectMissing($prefix . $wire . '.', $missing, $setters);
            } elseif (is_array($value)) {
                foreach ($value as $index => $item) {
                    if ($item instanceof self) {
                        $item->collectMissing($prefix . $wire . '[' . $index . '].', $missing, $setters);
                    }
                }
            }
        }
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
