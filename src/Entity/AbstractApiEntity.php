<?php

declare(strict_types=1);

namespace Simplia\Api3\Entity;

use Simplia\Api3\Money;

/**
 * One record as the API returned it. A member you did not select is not there — the reader throws and names the
 * path to add to the field config. A member of a type the server did not promise throws too: the client never
 * casts silently.
 */
abstract class AbstractApiEntity {

    /** @param array<string, mixed> $data */
    public function __construct(private readonly array $data, private readonly string $fieldPrefix = '') {
    }

    private function raw(string $key): mixed {
        if (!array_key_exists($key, $this->data)) {
            throw new \RuntimeException('Field "' . $this->fieldPrefix . $key . '" was not loaded - add it to the field config first.');
        }

        return $this->data[$key];
    }

    private function unexpected(string $key, string $expected): \UnexpectedValueException {
        return new \UnexpectedValueException('Field "' . $this->fieldPrefix . $key . '" is not ' . $expected . '.');
    }

    final protected function readInt(string $key): int {
        return $this->readIntOrNull($key) ?? throw $this->unexpected($key, 'an integer');
    }

    final protected function readIntOrNull(string $key): ?int {
        $value = $this->raw($key);
        if ($value !== null && !is_int($value)) {
            throw $this->unexpected($key, 'an integer');
        }

        return $value;
    }

    final protected function readString(string $key): string {
        return $this->readStringOrNull($key) ?? throw $this->unexpected($key, 'a string');
    }

    final protected function readStringOrNull(string $key): ?string {
        $value = $this->raw($key);
        if ($value !== null && !is_string($value)) {
            throw $this->unexpected($key, 'a string');
        }

        return $value;
    }

    final protected function readBool(string $key): bool {
        return $this->readBoolOrNull($key) ?? throw $this->unexpected($key, 'a boolean');
    }

    final protected function readBoolOrNull(string $key): ?bool {
        $value = $this->raw($key);
        if ($value !== null && !is_bool($value)) {
            throw $this->unexpected($key, 'a boolean');
        }

        return $value;
    }

    final protected function readFloat(string $key): float {
        return $this->readFloatOrNull($key) ?? throw $this->unexpected($key, 'a number');
    }

    final protected function readFloatOrNull(string $key): ?float {
        $value = $this->raw($key);
        if ($value === null) {
            return null;
        }
        if (!is_int($value) && !is_float($value)) {
            throw $this->unexpected($key, 'a number');
        }

        return (float) $value;
    }

    final protected function readMoney(string $key): Money {
        return $this->readMoneyOrNull($key) ?? throw $this->unexpected($key, 'a money value');
    }

    final protected function readMoneyOrNull(string $key): ?Money {
        $value = $this->raw($key);
        if ($value === null) {
            return null;
        }
        if (!is_array($value)) {
            throw $this->unexpected($key, 'a money value');
        }

        return Money::fromArray($value);
    }

    final protected function readDateTime(string $key): \DateTimeImmutable {
        return $this->readDateTimeOrNull($key) ?? throw $this->unexpected($key, 'a date-time');
    }

    final protected function readDateTimeOrNull(string $key): ?\DateTimeImmutable {
        $value = $this->readStringOrNull($key);
        if ($value === null) {
            return null;
        }
        try {
            return new \DateTimeImmutable($value);
        } catch (\Exception) {
            throw $this->unexpected($key, 'a date-time');
        }
    }

    final protected function readDate(string $key): \DateTimeImmutable {
        return $this->readDateOrNull($key) ?? throw $this->unexpected($key, 'a date');
    }

    /** A calendar day as midnight in the default time zone; format it back with 'Y-m-d'. */
    final protected function readDateOrNull(string $key): ?\DateTimeImmutable {
        $value = $this->readStringOrNull($key);
        if ($value === null) {
            return null;
        }

        return \DateTimeImmutable::createFromFormat('!Y-m-d', $value) ?: throw $this->unexpected($key, 'a date');
    }

    /**
     * @template T of AbstractApiEntity
     * @param class-string<T> $class
     * @return T
     */
    final protected function readEntity(string $key, string $class): AbstractApiEntity {
        return $this->readEntityOrNull($key, $class) ?? throw $this->unexpected($key, 'a record');
    }

    /**
     * @template T of AbstractApiEntity
     * @param class-string<T> $class
     * @return T|null
     */
    final protected function readEntityOrNull(string $key, string $class): ?AbstractApiEntity {
        $value = $this->raw($key);
        if ($value === null) {
            return null;
        }
        if (!is_array($value)) {
            throw $this->unexpected($key, 'a record');
        }

        return new $class($value, $this->fieldPrefix . $key . '.');
    }

    /**
     * @template T of AbstractApiEntity
     * @param class-string<T> $class
     * @return list<T>
     */
    final protected function readEntities(string $key, string $class): array {
        $value = $this->raw($key);
        if (!is_array($value)) {
            throw $this->unexpected($key, 'a list of records');
        }
        $entities = [];
        foreach ($value as $row) {
            if (!is_array($row)) {
                throw $this->unexpected($key, 'a list of records');
            }
            $entities[] = new $class($row, $this->fieldPrefix . $key . '.');
        }

        return $entities;
    }

    /** @return list<Money> */
    final protected function readMoneyList(string $key): array {
        $value = $this->raw($key);
        if (!is_array($value)) {
            throw $this->unexpected($key, 'a list of money values');
        }
        $list = [];
        foreach ($value as $item) {
            if (!is_array($item)) {
                throw $this->unexpected($key, 'a list of money values');
            }
            $list[] = Money::fromArray($item);
        }

        return $list;
    }

    /** @return list<int> */
    final protected function readIntList(string $key): array {
        $value = $this->raw($key);
        if (!is_array($value)) {
            throw $this->unexpected($key, 'a list of integers');
        }
        $list = [];
        foreach ($value as $item) {
            if (!is_int($item)) {
                throw $this->unexpected($key, 'a list of integers');
            }
            $list[] = $item;
        }

        return $list;
    }

    /** @return list<string> */
    final protected function readStringList(string $key): array {
        $value = $this->raw($key);
        if (!is_array($value)) {
            throw $this->unexpected($key, 'a list of strings');
        }
        $list = [];
        foreach ($value as $item) {
            if (!is_string($item)) {
                throw $this->unexpected($key, 'a list of strings');
            }
            $list[] = $item;
        }

        return $list;
    }

    /** @return array<string, mixed> */
    final protected function readArray(string $key): array {
        return $this->readArrayOrNull($key) ?? throw $this->unexpected($key, 'an object');
    }

    /** @return array<string, mixed>|null */
    final protected function readArrayOrNull(string $key): ?array {
        $value = $this->raw($key);
        if ($value !== null && !is_array($value)) {
            throw $this->unexpected($key, 'an object');
        }

        return $value;
    }
}
