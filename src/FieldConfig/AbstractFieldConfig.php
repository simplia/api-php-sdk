<?php

namespace Simplia\Api\FieldConfig;

abstract class AbstractFieldConfig {
    protected array $fields = [];

    /**
     * @return string[]
     */
    public function toArray(): array {
        $fields = [];
        foreach ($this->fields as $field => $content) {
            if ($content instanceof self) {
                foreach ($content->toArray() as $subField) {
                    $fields[] = $field . '.' . $subField;
                }
            } else {
                $fields[] = $field;
            }
        }

        return $fields;
    }
}
