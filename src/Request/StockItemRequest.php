<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Request;

class StockItemRequest extends AbstractApiRequest {
    /**
     * @param int[] $ids Stock item IDs
     * @return $this
     */
    public function whereIds(array $ids): self {
        $this->params['ids'] = $ids;

        return $this;
    }

    /**
     * @param string[] $codes Stock item codes
     * @return $this
     */
    public function whereCodes(array $codes): self {
        $this->params['codes'] = $codes;

        return $this;
    }

    /**
     * @param bool $inStock Only items currently in stock
     * @return $this
     */
    public function whereInStock(bool $inStock): self {
        $this->params['in_stock'] = $inStock ? 'true' : 'false';

        return $this;
    }
}
