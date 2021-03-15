<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Entity;

use Simplia\Api\FieldConfig\PackageApiFieldConfig;

class PackageApiEntity extends AbstractApiEntity {
    public function getId(): int {
        return $this->returnField('id');
    }

    public function getName(): ?string {
        return $this->returnField('name');
    }

    public function getCompany(): ?string {
        return $this->returnField('company');
    }

    public function getStreet(): ?string {
        return $this->returnField('street');
    }

    public function getCity(): ?string {
        return $this->returnField('city');
    }

    public function getZip(): ?string {
        return $this->returnField('zip');
    }

    public function getPhone(): ?string {
        return $this->returnField('phone');
    }

    public function getEmail(): ?string {
        return $this->returnField('email');
    }

    public function getCode(): ?string {
        return $this->returnField('code');
    }

    public function getCountry(): ?string {
        return $this->returnField('country');
    }

    public function getCurrency(): string {
        return $this->returnField('currency');
    }

    public function getVariableSymbol(): string {
        return $this->returnField('variable_symbol');
    }

    public function isPaid(): bool {
        return $this->returnField('paid');
    }

    public function getStatus(): int {
        return $this->returnField('status');
    }

    public function getWeight(): ?float {
        return $this->returnField('weight');
    }

    public function getCurrencyRate(): float {
        return $this->returnField('currency_rate');
    }

    public function getCashOnDelivery(): float {
        return $this->returnField('cash_on_delivery');
    }

    public function getPrice(): ?float {
        return $this->returnField('price');
    }

    public function getDate(): string {
        return $this->returnField('date');
    }

    final public static function createFieldConfig(): PackageApiFieldConfig {
        return new PackageApiFieldConfig();
    }
}
