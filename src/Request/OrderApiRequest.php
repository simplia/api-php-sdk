<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Request;

class OrderApiRequest extends AbstractApiRequest {
    /**
     * @param string[] $status Order status
     * @return $this
     */
    public function whereStatus(array $status): self {
        $this->params['status'] = $status;

        return $this;
    }

    /**
     * @param string $email Customer email.
     * @return $this
     */
    public function whereEmail(string $email): self {
        $this->params['email'] = $email;

        return $this;
    }

    /**
     * @param string $phone Customer phone.
     * @return $this
     */
    public function wherePhone(string $phone): self {
        $this->params['phone'] = $phone;

        return $this;
    }

    public function orderByDateAsc(): self {
        $this->params['sort'] = 'date';

        return $this;
    }

    public function orderByDateDesc(): self {
        $this->params['sort'] = '-date';

        return $this;
    }

    /**
     * @param string $dateFrom Orders created from date
     * @return $this
     */
    public function whereDateFrom(string $dateFrom): self {
        $this->params['date_from'] = $dateFrom;

        return $this;
    }

    /**
     * @param string $dateTo Orders created to date
     * @return $this
     */
    public function whereDateTo(string $dateTo): self {
        $this->params['date_to'] = $dateTo;

        return $this;
    }

    /**
     * @param string $dateStatusFrom Orders with status change from date
     * @return $this
     */
    public function whereDateStatusFrom(string $dateStatusFrom): self {
        $this->params['date_status_from'] = $dateStatusFrom;

        return $this;
    }

    /**
     * @param string $dateStatusTo Orders with status change to date
     * @return $this
     */
    public function whereDateStatusTo(string $dateStatusTo): self {
        $this->params['date_status_to'] = $dateStatusTo;

        return $this;
    }

    /**
     * @param string $dateChangedFrom Orders changed from date
     * @return $this
     */
    public function whereDateChangedFrom(string $dateChangedFrom): self {
        $this->params['date_changed_from'] = $dateChangedFrom;

        return $this;
    }

    /**
     * @param string $dateChangedTo Orders changed to date
     * @return $this
     */
    public function whereDateChangedTo(string $dateChangedTo): self {
        $this->params['date_changed_to'] = $dateChangedTo;

        return $this;
    }

    /**
     * @param int[] $ids Order IDs
     * @return $this
     */
    public function whereIds(array $ids): self {
        $this->params['ids'] = $ids;

        return $this;
    }
}
