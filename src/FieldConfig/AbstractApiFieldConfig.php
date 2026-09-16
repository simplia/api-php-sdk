<?php

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

/**
 * Which properties to fetch, as the API's `fields` parameter: dotted paths into embeds; an embed with no member
 * selected is named bare and answers its `id`; `id` is implicit on every level.
 */
abstract class AbstractApiFieldConfig {

    /** @var array<string, true|AbstractApiFieldConfig> */
    protected array $fields = [];

    /**
     * A copy selects on its own nested configs: PHP's clone is shallow, so without this a config cloned as a
     * base — what the README tells a caller to do — shared every nested config with the original, and one more
     * `select…()` on the copy silently widened the base too.
     */
    public function __clone() {
        foreach ($this->fields as $field => $content) {
            if ($content instanceof self) {
                $this->fields[$field] = clone $content;
            }
        }
    }

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
