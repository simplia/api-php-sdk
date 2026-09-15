<?php

declare(strict_types=1);

namespace Simplia\Api3\FieldConfig;

/**
 * Which properties to fetch, as the API's `fields` parameter: dotted paths into embeds; an embed with no member
 * selected is named bare and answers its `id`; `id` is implicit on every level.
 */
abstract class AbstractApiFieldConfig {

    /** @var array<string, true|AbstractApiFieldConfig> */
    protected array $fields = [];

    /** @return list<string> */
    public function toArray(): array {
        $fields = [];
        foreach ($this->fields as $field => $content) {
            if ($content instanceof self) {
                $sub = $content->toArray();
                if ($sub === []) {
                    $fields[] = $field;
                }
                foreach ($sub as $subField) {
                    $fields[] = $field . '.' . $subField;
                }
            } else {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    public function toQueryValue(): string {
        return implode(',', $this->toArray());
    }
}
