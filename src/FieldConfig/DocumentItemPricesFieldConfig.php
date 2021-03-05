<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class DocumentItemPricesFieldConfig extends AbstractFieldConfig {
    public function withItems(): self {
        $this->fields['items'] = true;

        return $this;
    }
}
