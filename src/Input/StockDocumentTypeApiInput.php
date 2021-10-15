<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

use Simplia\Api\Input\AbstractApiInput;
use Simplia\Api\Input\StockDocumentItemTypeApiInput;

class StockDocumentTypeApiInput extends AbstractApiInput {
    public function setId(string $id): self {
        $this->params['id'] = $id;

        return $this;
    }

    public function setStockRoomId(float $stockRoomId): self {
        $this->params['stock_room_id'] = $stockRoomId;

        return $this;
    }

    public function setDateIssued(string $dateIssued): self {
        $this->params['date_issued'] = $dateIssued;

        return $this;
    }

    public function setType(string $type): self {
        $this->params['type'] = $type;

        return $this;
    }

    /**
     * @param StockDocumentItemTypeApiInput[] $items
     * @return $this
     */
    public function setItems(array $items): self {
        self::validateArray($items, StockDocumentItemTypeApiInput::class);
        $this->params['items'] = $items;

        return $this;
    }
}
