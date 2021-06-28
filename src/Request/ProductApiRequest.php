<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Request;

class ProductApiRequest extends AbstractApiRequest {
    /**
     * @param int[] $ids Product IDs
     * @return $this
     */
    public function whereIds(array $ids): self {
        $this->params['ids'] = $ids;

        return $this;
    }

    /**
     * @param string[] $codes Product codes
     * @return $this
     */
    public function whereCodes(array $codes): self {
        $this->params['codes'] = $codes;

        return $this;
    }
}