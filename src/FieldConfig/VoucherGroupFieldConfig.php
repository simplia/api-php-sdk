<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class VoucherGroupFieldConfig extends AbstractFieldConfig {
    public function withId(): self {
        $this->fields['id'] = true;

        return $this;
    }

    public function withName(): self {
        $this->fields['name'] = true;

        return $this;
    }
}
