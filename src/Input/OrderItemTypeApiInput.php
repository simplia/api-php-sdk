<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class OrderItemTypeApiInput extends AbstractApiInput {
    public function setItemId(int $itemId): self {
        $this->params['item_id'] = $itemId;

        return $this;
    }

    public function setItemCode(string $itemCode): self {
        $this->params['item_code'] = $itemCode;

        return $this;
    }

    public function setQuantity(int $quantity): self {
        $this->params['quantity'] = $quantity;

        return $this;
    }

    public function setPriceVat(float $priceVat): self {
        $this->params['price_vat'] = $priceVat;

        return $this;
    }

    public function setVatRate(float $vatRate): self {
        $this->params['vat_rate'] = $vatRate;

        return $this;
    }
}