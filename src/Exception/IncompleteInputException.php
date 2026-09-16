<?php

declare(strict_types=1);

namespace Simplia\Api\Exception;

/**
 * An input reached an endpoint without a property its schema requires. Thrown by the client before any request is
 * built — a programming error, not an answer of the API, hence a LogicException rather than an ApiProblemException.
 * `getMissing()` lists the wire paths (`delivery.payment_price`, `items[1].price`); the message names the setters.
 */
final class IncompleteInputException extends \LogicException {

    /**
     * @param class-string $inputClass the outermost input
     * @param list<string> $missing wire paths, in the inputs' REQUIRED order
     * @param list<string> $setters what to call, one per missing path (`setDelivery()`, `setPrice() on OrderItemApiInput`)
     */
    public function __construct(private readonly string $inputClass, private readonly array $missing, array $setters) {
        parent::__construct(sprintf(
            '%s is missing %s — call %s before sending.',
            (new \ReflectionClass($inputClass))->getShortName(),
            implode(', ', $missing),
            implode(', ', $setters),
        ));
    }

    /** @return class-string */
    public function getInputClass(): string {
        return $this->inputClass;
    }

    /** @return list<string> */
    public function getMissing(): array {
        return $this->missing;
    }
}
