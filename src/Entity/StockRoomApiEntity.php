<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Entity;

use Simplia\Api\FieldConfig\StockRoomApiFieldConfig;

class StockRoomApiEntity extends AbstractApiEntity {
    public function getId(): int {
        return $this->returnField('id');
    }

    public function getName(): string {
        return $this->returnField('name');
    }

    public function getStorageCenter(): StockStorageCenterApiEntity {
        return $this->returnField('storage_center', StockStorageCenterApiEntity::class);
    }

    final public static function createFieldConfig(): StockRoomApiFieldConfig {
        return new StockRoomApiFieldConfig();
    }
}
