<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class VoucherApplyTypeApiInput extends AbstractApiInput {
    public function setKey(string $key): self {
        $this->params['key'] = $key;

        return $this;
    }
}
