<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class VariantApiFieldConfig extends AbstractApiFieldConfig {
    public function withId(): self {
        $this->fields['id'] = true;

        return $this;
    }

    public function withName(): self {
        $this->fields['name'] = true;

        return $this;
    }

    public function withCode(): self {
        $this->fields['code'] = true;

        return $this;
    }

    public function withPriceVat(): self {
        $this->fields['price_vat'] = true;

        return $this;
    }

    public function withCodeSupplier(): self {
        $this->fields['code_supplier'] = true;

        return $this;
    }

    public function withEan(): self {
        $this->fields['ean'] = true;

        return $this;
    }

    public function withCreated(): self {
        $this->fields['created'] = true;

        return $this;
    }
}
