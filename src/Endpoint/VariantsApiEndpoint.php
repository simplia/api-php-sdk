<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Endpoint;

use Simplia\Api\Entity\VariantApiEntity;
use Simplia\Api\FieldConfig\VariantApiFieldConfig;
use Simplia\Api\Input\VariantTypeApiInput;

class VariantsApiEndpoint extends AbstractApiEndpoint {
    /**
     * Create new variant
     * @param string $product
     */
    final public function create(
        VariantTypeApiInput $input,
        string $product,
        ?VariantApiFieldConfig $fields = null
    ): VariantApiEntity {
        $query = [];
        $query['product'] = $product;
        $result = $this->request('POST', 'variants', $query, $input, $fields);

        return new VariantApiEntity($result);
    }

    /**
     * Update existing variant (patch)
     */
    final public function update(
        int $id,
        VariantTypeApiInput $input,
        ?VariantApiFieldConfig $fields = null
    ): VariantApiEntity {
        $result = $this->request('PATCH', 'variants/' . $id, [], $input, $fields);

        return new VariantApiEntity($result);
    }
}
