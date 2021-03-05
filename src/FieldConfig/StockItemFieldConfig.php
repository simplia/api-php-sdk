<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class StockItemFieldConfig extends AbstractFieldConfig {
    public function withId(): self {
        $this->fields['id'] = true;

        return $this;
    }

    public function withCode(): self {
        $this->fields['code'] = true;

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

    public function withTotalStockAmount(): self {
        $this->fields['total_stock_amount'] = true;

        return $this;
    }

    public function withName(): self {
        $this->fields['name'] = true;

        return $this;
    }

    public function withStorageLocations(): self {
        $this->fields['storage_locations'] = true;

        return $this;
    }

    public function withProduct(ProductFieldConfig $config): self {
        $this->fields['product'] = $config;

        return $this;
    }

    public function withVariant(VariantFieldConfig $config): self {
        $this->fields['variant'] = $config;

        return $this;
    }
}
