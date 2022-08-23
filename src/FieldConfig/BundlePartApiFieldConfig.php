<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class BundlePartApiFieldConfig extends AbstractApiFieldConfig {
    public function withId(): self {
        $this->fields['id'] = true;

        return $this;
    }

    public function withQuantity(): self {
        $this->fields['quantity'] = true;

        return $this;
    }

    public function withStockItem(StockItemApiFieldConfig $config): self {
        $this->fields['stock_item'] = $config;

        return $this;
    }
}
