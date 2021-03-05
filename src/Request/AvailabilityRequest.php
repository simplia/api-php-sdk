<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Request;

class AvailabilityRequest extends AbstractApiRequest {
    /**
     * @param int[] $ids Availability IDs
     * @return $this
     */
    public function whereIds(array $ids): self {
        $this->params['ids'] = $ids;

        return $this;
    }
}
