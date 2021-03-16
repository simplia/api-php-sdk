<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Request;

class PaymentApiRequest extends AbstractApiRequest {
    public function orderByDateAsc(): self {
        $this->params['sort'] = 'date';

        return $this;
    }

    public function orderByDateDesc(): self {
        $this->params['sort'] = '-date';

        return $this;
    }

    /**
     * @param string $dateFrom Payments created from date
     * @return $this
     */
    public function whereDateFrom(string $dateFrom): self {
        $this->params['date_from'] = $dateFrom;

        return $this;
    }

    /**
     * @param string $dateTo Payments created to date
     * @return $this
     */
    public function whereDateTo(string $dateTo): self {
        $this->params['date_to'] = $dateTo;

        return $this;
    }

    /**
     * @param bool $type Payment type
     * @return $this
     */
    public function whereType(bool $type): self {
        $this->params['type'] = $type ? 'true' : 'false';

        return $this;
    }

    /**
     * @param int[] $ids Payment IDs
     * @return $this
     */
    public function whereIds(array $ids): self {
        $this->params['ids'] = $ids;

        return $this;
    }
}