<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class StockItemBatchTypeInput extends AbstractApiInput {
    /**
     * @param StockItemTypeInput[] $items
     * @return $this
     */
    public function setItems(array $items): self {
        self::validateArray($items, StockItemTypeInput::class);
        $this->params['items'] = $items;

        return $this;
    }
}
