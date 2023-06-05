<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class StockItemAmountApiFieldConfig extends AbstractApiFieldConfig {
    public function withStockRoom(StockRoomApiFieldConfig $config): self {
        $this->fields['stock_room'] = $config;

        return $this;
    }

    public function withStockItem(StockItemApiFieldConfig $config): self {
        $this->fields['stock_item'] = $config;

        return $this;
    }

    public function withStockAmount(): self {
        $this->fields['stock_amount'] = true;

        return $this;
    }

    public function withReservedAmount(): self {
        $this->fields['reserved_amount'] = true;

        return $this;
    }

    public function withMinimalAmount(): self {
        $this->fields['minimal_amount'] = true;

        return $this;
    }

    public function withOptimalAmount(): self {
        $this->fields['optimal_amount'] = true;

        return $this;
    }

    public function withMaximalAmount(): self {
        $this->fields['maximal_amount'] = true;

        return $this;
    }
}