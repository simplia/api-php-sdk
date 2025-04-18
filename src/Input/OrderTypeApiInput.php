<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class OrderTypeApiInput extends AbstractApiInput {
    public function setPackagingNote(string $packagingNote): self {
        $this->params['packaging_note'] = $packagingNote;

        return $this;
    }

    public function setStorageCenterId(int $storageCenterId): self {
        $this->params['storage_center_id'] = $storageCenterId;

        return $this;
    }
}
