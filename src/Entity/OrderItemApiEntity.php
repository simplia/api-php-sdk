<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Entity;

use Simplia\Api\FieldConfig\OrderItemApiFieldConfig;

class OrderItemApiEntity extends AbstractApiEntity {
    public function getId(): int {
        return $this->returnField('id');
    }

    public function getName(): string {
        return $this->returnField('name');
    }

    public function getNote(): ?string {
        return $this->returnField('note');
    }

    public function getCode(): string {
        return $this->returnField('code');
    }

    public function getAmount(): int {
        return $this->returnField('amount');
    }

    public function getPrice(): float {
        return $this->returnField('price');
    }

    public function getVatRate(): float {
        return $this->returnField('vat_rate');
    }

    public function getStockItem(): StockItemApiEntity {
        return $this->returnField('stock_item', StockItemApiEntity::class);
    }

    final public static function createFieldConfig(): OrderItemApiFieldConfig {
        return new OrderItemApiFieldConfig();
    }
}
