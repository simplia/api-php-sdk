<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class OrderCreateTypeApiInput extends AbstractApiInput {
    public function setExternalCode(string $externalCode): self {
        $this->params['external_code'] = $externalCode;

        return $this;
    }

    /**
     * @param OrderItemTypeApiInput[] $items
     * @return $this
     */
    public function setItems(array $items): self {
        self::validateArray($items, OrderItemTypeApiInput::class);
        $this->params['items'] = $items;

        return $this;
    }

    public function setDeliveryAddress(AddressTypeApiInput $deliveryAddress): self {
        $this->params['delivery_address'] = $deliveryAddress;

        return $this;
    }

    public function setInvoiceAddress(AddressTypeApiInput $invoiceAddress): self {
        $this->params['invoice_address'] = $invoiceAddress;

        return $this;
    }

    public function setDelivery(OrderDeliveryTypeApiInput $delivery): self {
        $this->params['delivery'] = $delivery;

        return $this;
    }

    public function setStoreId(int $storeId): self {
        $this->params['store_id'] = $storeId;

        return $this;
    }

    public function setCreatedStoreId(int $createdStoreId): self {
        $this->params['created_store_id'] = $createdStoreId;

        return $this;
    }

    public function setStorageCenterId(int $storageCenterId): self {
        $this->params['storage_center_id'] = $storageCenterId;

        return $this;
    }

    public function setCustomerNote(string $customerNote): self {
        $this->params['customer_note'] = $customerNote;

        return $this;
    }

    public function setInvoiceNote(string $invoiceNote): self {
        $this->params['invoice_note'] = $invoiceNote;

        return $this;
    }

    public function setVariableSymbol(int $variableSymbol): self {
        $this->params['variable_symbol'] = $variableSymbol;

        return $this;
    }

    public function setSendConfirmationEmail(bool $sendConfirmationEmail): self {
        $this->params['send_confirmation_email'] = $sendConfirmationEmail ? 'true' : 'false';

        return $this;
    }
}
