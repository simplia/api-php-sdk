<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

use Simplia\Api\Input\AbstractApiInput;

class VoucherActivateTypeApiInput extends AbstractApiInput {
    public function setKey(string $key): self {
        $this->params['key'] = $key;

        return $this;
    }

    public function setNote(string $note): self {
        $this->params['note'] = $note;

        return $this;
    }
}
