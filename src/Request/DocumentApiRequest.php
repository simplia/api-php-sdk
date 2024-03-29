<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Request;

class DocumentApiRequest extends AbstractApiRequest {
    public function orderByDateAsc(): self {
        $this->params['sort'] = 'date';

        return $this;
    }

    public function orderByDateDesc(): self {
        $this->params['sort'] = '-date';

        return $this;
    }

    /**
     * @param string $dateFrom Documents issued from date
     * @return $this
     */
    public function whereDateFrom(string $dateFrom): self {
        $this->params['date_from'] = $dateFrom;

        return $this;
    }

    /**
     * @param string $dateTo Documents issued to date
     * @return $this
     */
    public function whereDateTo(string $dateTo): self {
        $this->params['date_to'] = $dateTo;

        return $this;
    }

    /**
     * @param int[] $ids Document IDs
     * @return $this
     */
    public function whereIds(array $ids): self {
        $this->params['ids'] = $ids;

        return $this;
    }

    /**
     * @param string[] $codes Document codes
     * @return $this
     */
    public function whereCodes(array $codes): self {
        $this->params['codes'] = $codes;

        return $this;
    }
}
