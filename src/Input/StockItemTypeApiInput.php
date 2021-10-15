<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

use Simplia\Api\Input\AbstractApiInput;

class StockItemTypeApiInput extends AbstractApiInput {
    public function setId(int $id): self {
        $this->params['id'] = $id;

        return $this;
    }

    public function setPrice(float $price): self {
        $this->params['price'] = $price;

        return $this;
    }

    public function setAvailabilityHours(float $availabilityHours): self {
        $this->params['availability_hours'] = $availabilityHours;

        return $this;
    }

    public function setEan(string $ean): self {
        $this->params['ean'] = $ean;

        return $this;
    }
}
