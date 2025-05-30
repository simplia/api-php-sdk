<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class StockItemTypeApiInput extends AbstractApiInput {
    public function setId(int $id): self {
        $this->params['id'] = $id;

        return $this;
    }

    public function setPrice(float $price): self {
        $this->params['price'] = $price;

        return $this;
    }

    public function setPriceOriginal(float $priceOriginal): self {
        $this->params['price_original'] = $priceOriginal;

        return $this;
    }

    public function setVat(float $vat): self {
        $this->params['vat'] = $vat;

        return $this;
    }

    public function setAvailabilityHours(float $availabilityHours): self {
        $this->params['availability_hours'] = $availabilityHours;

        return $this;
    }

    public function setAvailabilityDate(string $availabilityDate): self {
        $this->params['availability_date'] = $availabilityDate;

        return $this;
    }

    public function setEan(string $ean): self {
        $this->params['ean'] = $ean;

        return $this;
    }

    public function setDiscountPercentage(float $discountPercentage): self {
        $this->params['discount_percentage'] = $discountPercentage;

        return $this;
    }

    public function setDiscountValue(float $discountValue): self {
        $this->params['discount_value'] = $discountValue;

        return $this;
    }

    public function setDiscountValidFrom(string $discountValidFrom): self {
        $this->params['discount_valid_from'] = $discountValidFrom;

        return $this;
    }

    public function setDiscountValidTo(string $discountValidTo): self {
        $this->params['discount_valid_to'] = $discountValidTo;

        return $this;
    }
}
