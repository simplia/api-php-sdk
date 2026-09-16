<?php

declare(strict_types=1);

namespace Simplia\Api\Request;

/** The filters and the sort of one list call; the generated subclass adds a `where…()` per filter and `orderBy…()` per sort. */
abstract class AbstractApiRequest {

    /** @var array<string, mixed> */
    protected array $params = [];

    final public function __construct() {
    }

    /** @return array<string, mixed> */
    public function toArray(): array {
        return $this->params;
    }

    public static function create(): static {
        return new static();
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
}
