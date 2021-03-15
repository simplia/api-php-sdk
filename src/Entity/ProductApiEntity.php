<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Entity;

use Simplia\Api\FieldConfig\ProductApiFieldConfig;

class ProductApiEntity extends AbstractApiEntity {
    public function getId(): int {
        return $this->returnField('id');
    }

    public function getName(): string {
        return $this->returnField('name');
    }

    public function getShortDescription(): string {
        return $this->returnField('short_description');
    }

    public function getLongDescription(): string {
        return $this->returnField('long_description');
    }

    public function getBrand(): BrandApiEntity {
        return $this->returnField('brand', BrandApiEntity::class);
    }

    public function getSupplier(): SupplierApiEntity {
        return $this->returnField('supplier', SupplierApiEntity::class);
    }

    public function getCode(): string {
        return $this->returnField('code');
    }

    public function getCodeSupplier(): ?string {
        return $this->returnField('code_supplier');
    }

    public function getEan(): ?string {
        return $this->returnField('ean');
    }

    final public static function createFieldConfig(): ProductApiFieldConfig {
        return new ProductApiFieldConfig();
    }
}
