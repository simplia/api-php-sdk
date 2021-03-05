<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Entity;

use Simplia\Api\FieldConfig\ArticleFieldConfig;

class ArticleApiEntity extends AbstractApiEntity {
    public function getId(): int {
        return $this->returnField('id');
    }

    public function getName(): string {
        return $this->returnField('name');
    }

    public function getAnnotation(): string {
        return $this->returnField('annotation');
    }

    public function getText(): string {
        return $this->returnField('text');
    }

    public function getPublished(): string {
        return $this->returnField('published');
    }

    public function getUrl(): string {
        return $this->returnField('url');
    }

    final public static function createFieldConfig(): ArticleFieldConfig {
        return new ArticleFieldConfig();
    }
}
