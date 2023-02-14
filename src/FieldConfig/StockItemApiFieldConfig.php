<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class StockItemApiFieldConfig extends AbstractApiFieldConfig {
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

    public function withFullPrice(): self {
        $this->fields['full_price'] = true;

        return $this;
    }

    public function withAccountingValue(): self {
        $this->fields['accounting_value'] = true;

        return $this;
    }

    public function withTotalStockAmount(): self {
        $this->fields['total_stock_amount'] = true;

        return $this;
    }

    public function withTotalReservedStockAmount(): self {
        $this->fields['total_reserved_stock_amount'] = true;

        return $this;
    }

    public function withTotalBlockedStockAmount(): self {
        $this->fields['total_blocked_stock_amount'] = true;

        return $this;
    }

    public function withAvailabilityHours(): self {
        $this->fields['availability_hours'] = true;

        return $this;
    }

    public function withAvailabilityDate(): self {
        $this->fields['availability_date'] = true;

        return $this;
    }

    public function withName(): self {
        $this->fields['name'] = true;

        return $this;
    }

    public function withStorageLocations(StockStorageLocationApiFieldConfig $config): self {
        $this->fields['storage_locations'] = $config;

        return $this;
    }

    public function withProduct(ProductApiFieldConfig $config): self {
        $this->fields['product'] = $config;

        return $this;
    }

    public function withVariant(VariantApiFieldConfig $config): self {
        $this->fields['variant'] = $config;

        return $this;
    }

    public function withBundleParts(BundlePartApiFieldConfig $config): self {
        $this->fields['bundle_parts'] = $config;

        return $this;
    }
}
