<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class OrderApiFieldConfig extends AbstractApiFieldConfig {
    public function withId(): self {
        $this->fields['id'] = true;

        return $this;
    }

    public function withDateCreated(): self {
        $this->fields['date_created'] = true;

        return $this;
    }

    public function withDateDelayTo(): self {
        $this->fields['date_delay_to'] = true;

        return $this;
    }

    public function withDateInStatus(): self {
        $this->fields['date_in_status'] = true;

        return $this;
    }

    public function withCurrency(): self {
        $this->fields['currency'] = true;

        return $this;
    }

    public function withFulfillment(): self {
        $this->fields['fulfillment'] = true;

        return $this;
    }

    public function withStatus(): self {
        $this->fields['status'] = true;

        return $this;
    }

    public function withCurrencyRate(): self {
        $this->fields['currency_rate'] = true;

        return $this;
    }

    public function withCarrierCode(): self {
        $this->fields['carrier_code'] = true;

        return $this;
    }

    public function withDeliveryPrice(): self {
        $this->fields['delivery_price'] = true;

        return $this;
    }

    public function withDeliveryPriceWithoutVat(): self {
        $this->fields['delivery_price_without_vat'] = true;

        return $this;
    }

    public function withDeliveryName(): self {
        $this->fields['delivery_name'] = true;

        return $this;
    }

    public function withPaymentType(): self {
        $this->fields['payment_type'] = true;

        return $this;
    }

    public function withStore(StoreApiFieldConfig $config): self {
        $this->fields['store'] = $config;

        return $this;
    }

    public function withCreatedStore(StoreApiFieldConfig $config): self {
        $this->fields['created_store'] = $config;

        return $this;
    }

    public function withCreatedBy(AdminApiFieldConfig $config): self {
        $this->fields['created_by'] = $config;

        return $this;
    }

    public function withStorageCenter(StockStorageCenterApiFieldConfig $config): self {
        $this->fields['storage_center'] = $config;

        return $this;
    }

    public function withNote(): self {
        $this->fields['note'] = true;

        return $this;
    }

    public function withInvoiceNote(): self {
        $this->fields['invoice_note'] = true;

        return $this;
    }

    public function withVariableSymbol(): self {
        $this->fields['variable_symbol'] = true;

        return $this;
    }

    public function withPriority(): self {
        $this->fields['priority'] = true;

        return $this;
    }

    public function withItems(OrderItemApiFieldConfig $config): self {
        $this->fields['items'] = $config;

        return $this;
    }

    public function withPayments(PaymentApiFieldConfig $config): self {
        $this->fields['payments'] = $config;

        return $this;
    }

    public function withDiscounts(OrderDiscountApiFieldConfig $config): self {
        $this->fields['discounts'] = $config;

        return $this;
    }

    public function withPackages(PackageApiFieldConfig $config): self {
        $this->fields['packages'] = $config;

        return $this;
    }

    public function withPackagingHistories(OrderPackagingApiFieldConfig $config): self {
        $this->fields['packaging_histories'] = $config;

        return $this;
    }

    public function withDeliveryAddress(ContactApiFieldConfig $config): self {
        $this->fields['delivery_address'] = $config;

        return $this;
    }

    public function withInvoiceAddress(ContactApiFieldConfig $config): self {
        $this->fields['invoice_address'] = $config;

        return $this;
    }

    public function withTotalPrice(): self {
        $this->fields['total_price'] = true;

        return $this;
    }

    public function withTotalPriceWithoutVat(): self {
        $this->fields['total_price_without_vat'] = true;

        return $this;
    }

    public function withTotalPaid(): self {
        $this->fields['total_paid'] = true;

        return $this;
    }
}
