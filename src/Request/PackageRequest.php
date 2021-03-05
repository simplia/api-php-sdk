<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Request;

class PackageRequest extends AbstractApiRequest {
    public function orderByDateAsc(): self {
        $this->params['sort'] = 'date';

        return $this;
    }

    public function orderByDateDesc(): self {
        $this->params['sort'] = '-date';

        return $this;
    }

    /**
     * @param int[] $ids Package IDs
     * @return $this
     */
    public function whereIds(array $ids): self {
        $this->params['ids'] = $ids;

        return $this;
    }

    /**
     * @param string $carrier Carrier code
     * @return $this
     */
    public function whereCarrier(string $carrier): self {
        $this->params['carrier'] = $carrier;

        return $this;
    }

    /**
     * @param string $code Package code
     * @return $this
     */
    public function whereCode(string $code): self {
        $this->params['code'] = $code;

        return $this;
    }

    /**
     * @param int $shipmentId Shipment ID
     * @return $this
     */
    public function whereShipmentId(int $shipmentId): self {
        $this->params['shipment_id'] = $shipmentId;

        return $this;
    }

    /**
     * @param int $orderCode
     * @return $this
     */
    public function whereOrderCode(int $orderCode): self {
        $this->params['order_code'] = $orderCode;

        return $this;
    }

    /**
     * @param string $dateFrom
     * @return $this
     */
    public function whereDateFrom(string $dateFrom): self {
        $this->params['date_from'] = $dateFrom;

        return $this;
    }

    /**
     * @param string $dateTo
     * @return $this
     */
    public function whereDateTo(string $dateTo): self {
        $this->params['date_to'] = $dateTo;

        return $this;
    }
}
