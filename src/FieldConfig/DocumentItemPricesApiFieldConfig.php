<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class DocumentItemPricesApiFieldConfig extends AbstractApiFieldConfig {
    public function withItems(DocumentItemPriceApiFieldConfig $config): self {
        $this->fields['items'] = $config;

        return $this;
    }
}