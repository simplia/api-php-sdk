<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class DocumentItemApiFieldConfig extends AbstractApiFieldConfig {
    public function withId(): self {
        $this->fields['id'] = true;

        return $this;
    }

    public function withName(): self {
        $this->fields['name'] = true;

        return $this;
    }

    public function withAmount(): self {
        $this->fields['amount'] = true;

        return $this;
    }

    public function withItem(): self {
        return $this;
    }

    public function withPrice(): self {
        $this->fields['price'] = true;

        return $this;
    }

    public function withVatRate(): self {
        $this->fields['vat_rate'] = true;

        return $this;
    }

    public function withType(): self {
        $this->fields['type'] = true;

        return $this;
    }
}
