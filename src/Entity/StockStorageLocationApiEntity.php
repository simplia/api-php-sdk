<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Entity;

use Simplia\Api\FieldConfig\StockStorageLocationApiFieldConfig;

class StockStorageLocationApiEntity extends AbstractApiEntity {
    public function getId(): int {
        return $this->returnField('id');
    }

    public function getStorage(): StockStorageApiEntity {
        return $this->returnField('storage', StockStorageApiEntity::class);
    }

    public function getName(): string {
        return $this->returnField('name');
    }

    public function getDescription(): ?string {
        return $this->returnField('description');
    }

    final public static function createFieldConfig(): StockStorageLocationApiFieldConfig {
        return new StockStorageLocationApiFieldConfig();
    }
}
