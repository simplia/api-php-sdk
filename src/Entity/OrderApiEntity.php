<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Entity;

use Simplia\Api\FieldConfig\OrderApiFieldConfig;

class OrderApiEntity extends AbstractApiEntity {
    public function getId(): string {
        return $this->returnField('id');
    }

    public function getDateCreated(): string {
        return $this->returnField('date_created');
    }

    public function getDateInStatus(): ?string {
        return $this->returnField('date_in_status');
    }

    public function getCurrency(): string {
        return $this->returnField('currency');
    }

    public function isFulfillment(): bool {
        return $this->returnField('fulfillment');
    }

    public function getStatus(): string {
        return $this->returnField('status');
    }

    public function getCurrencyRate(): float {
        return $this->returnField('currency_rate');
    }

    public function getCarrierCode(): ?string {
        return $this->returnField('carrier_code');
    }

    public function getDeliveryPrice(): float {
        return $this->returnField('delivery_price');
    }

    public function getDeliveryPriceWithoutVat(): float {
        return $this->returnField('delivery_price_without_vat');
    }

    public function getDeliveryName(): ?string {
        return $this->returnField('delivery_name');
    }

    public function getPaymentType(): ?string {
        return $this->returnField('payment_type');
    }

    public function getNote(): ?string {
        return $this->returnField('note');
    }

    public function getVariableSymbol(): ?string {
        return $this->returnField('variable_symbol');
    }

    /**
     * @return OrderItemApiEntity[]
     */
    public function getItems(): array {
        return $this->returnFieldArray('items', OrderItemApiEntity::class);
    }

    /**
     * @return PaymentApiEntity[]
     */
    public function getPayments(): array {
        return $this->returnFieldArray('payments', PaymentApiEntity::class);
    }

    /**
     * @return OrderDiscountApiEntity[]
     */
    public function getDiscounts(): array {
        return $this->returnFieldArray('discounts', OrderDiscountApiEntity::class);
    }

    /**
     * @return PackageApiEntity[]
     */
    public function getPackages(): array {
        return $this->returnFieldArray('packages', PackageApiEntity::class);
    }

    /**
     * @return OrderPackagingApiEntity[]
     */
    public function getPackagingHistories(): array {
        return $this->returnFieldArray('packaging_histories', OrderPackagingApiEntity::class);
    }

    public function getDeliveryAddress(): ?ContactApiEntity {
        return $this->returnField('delivery_address', ContactApiEntity::class);
    }

    public function getInvoiceAddress(): ?ContactApiEntity {
        return $this->returnField('invoice_address', ContactApiEntity::class);
    }

    public function getTotalPrice(): float {
        return $this->returnField('total_price');
    }

    public function getTotalPriceWithoutVat(): float {
        return $this->returnField('total_price_without_vat');
    }

    public function getTotalPaid(): float {
        return $this->returnField('total_paid');
    }

    final public static function createFieldConfig(): OrderApiFieldConfig {
        return new OrderApiFieldConfig();
    }
}
