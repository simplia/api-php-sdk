<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class BundleTypeApiInput extends AbstractApiInput {
    /**
     * @param BundlerPartTypeApiInput[] $parts
     * @return $this
     */
    public function setParts(array $parts): self {
        self::validateArray($parts, BundlerPartTypeApiInput::class);
        $this->params['parts'] = $parts;

        return $this;
    }
}
