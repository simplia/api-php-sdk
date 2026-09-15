<?php

declare(strict_types=1);

namespace Simplia\Api\Exception;

/** A 422: the body or the query parameters were rejected; one Violation per rejected value. */
final class ValidationException extends ApiProblemException {

    /** @return list<Violation> */
    public function violations(): array {
        $violations = [];
        foreach ($this->getBody()['violations'] ?? [] as $violation) {
            if (!is_array($violation)) {
                continue;
            }
            $violations[] = new Violation(
                (string) ($violation['propertyPath'] ?? ''),
                (string) ($violation['message'] ?? ''),
                isset($violation['code']) ? (string) $violation['code'] : null,
            );
        }

        return $violations;
    }
}
