<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class VariantTypeApiInput extends AbstractApiInput {
    public function setName(string $name): self {
        $this->params['name'] = $name;

        return $this;
    }

    public function setCode(string $code): self {
        $this->params['code'] = $code;

        return $this;
    }

    public function setEan(string $ean): self {
        $this->params['ean'] = $ean;

        return $this;
    }

    public function setPriceVat(string $priceVat): self {
        $this->params['price_vat'] = $priceVat;

        return $this;
    }
}
