<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Entity;

use Simplia\Api\FieldConfig\DocumentItemApiFieldConfig;

class DocumentItemApiEntity extends AbstractApiEntity {
    public function getId(): int {
        return $this->returnField('id');
    }

    public function getName(): string {
        return $this->returnField('name');
    }

    public function getAmount(): int {
        return $this->returnField('amount');
    }

    public function getItem(): StockItemApiEntity {
        return $this->returnField('item', StockItemApiEntity::class);
    }

    public function getPrice(): float {
        return $this->returnField('price');
    }

    public function getVatRate(): float {
        return $this->returnField('vat_rate');
    }

    public function getType(): string {
        return $this->returnField('type');
    }

    final public static function createFieldConfig(): DocumentItemApiFieldConfig {
        return new DocumentItemApiFieldConfig();
    }
}
