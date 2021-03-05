<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Entity;

use Simplia\Api\FieldConfig\VoucherFieldConfig;

class VoucherApiEntity extends AbstractApiEntity {
    public function getId(): int {
        return $this->returnField('id');
    }

    public function getCode(): string {
        return $this->returnField('code');
    }

    public function getValidFrom(): string {
        return $this->returnField('valid_from');
    }

    public function getValidTo(): string {
        return $this->returnField('valid_to');
    }

    public function getPriceValue(): float {
        return $this->returnField('price_value');
    }

    public function isActive(): bool {
        return $this->returnField('active');
    }

    public function getGroup(): VoucherGroupApiEntity {
        return $this->returnField('group', VoucherGroupApiEntity::class);
    }

    public function getMaxUses(): int {
        return $this->returnField('max_uses');
    }

    public function getTotalUses(): int {
        return $this->returnField('total_uses');
    }

    public function isValid(): bool {
        return $this->returnField('valid');
    }

    final public static function createFieldConfig(): VoucherFieldConfig {
        return new VoucherFieldConfig();
    }
}