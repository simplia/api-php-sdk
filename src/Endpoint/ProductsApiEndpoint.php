<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Endpoint;

use Generator;
use Simplia\Api\Entity\ImageApiEntity;
use Simplia\Api\Entity\ProductApiEntity;
use Simplia\Api\FieldConfig\ImageApiFieldConfig;
use Simplia\Api\FieldConfig\ProductApiFieldConfig;
use Simplia\Api\Input\ImageUploadTypeApiInput;
use Simplia\Api\Input\ProductTypeApiInput;
use Simplia\Api\Request\ProductApiRequest;

class ProductsApiEndpoint extends AbstractApiEndpoint {
    /**
     * List products
     * @param ProductApiRequest $request
     * @param ProductApiFieldConfig $fields
     * @param int $batchSize
     * @return Generator|ProductApiEntity[]
     */
    final public function iterate(
        ProductApiRequest $request,
        ProductApiFieldConfig $fields,
        int $batchSize = 100
    ): Generator {
        foreach ($this->iterateList('products', [], $request, $fields, $batchSize) as $row) {
            yield new ProductApiEntity($row);
        }
        yield from [];
    }

    /**
     * Create new product
     * @param string $category
     */
    final public function create(
        ProductTypeApiInput $input,
        string $category,
        ?ProductApiFieldConfig $fields = null
    ): ProductApiEntity {
        $query = [];
        $query['category'] = $category;
        $result = $this->request('POST', 'products', $query, $input, $fields);

        return new ProductApiEntity($result);
    }

    /**
     * Update existing product (patch)
     */
    final public function update(
        int $id,
        ProductTypeApiInput $input,
        ?ProductApiFieldConfig $fields = null
    ): ProductApiEntity {
        $result = $this->request('PATCH', 'products/' . $id, [], $input, $fields);

        return new ProductApiEntity($result);
    }

    /**
     * Upload image to product
     */
    final public function uploadImage(
        int $id,
        ImageUploadTypeApiInput $input,
        ?ImageApiFieldConfig $fields = null
    ): ImageApiEntity {
        $result = $this->request('POST', 'products/' . $id . '/upload-image', [], $input, $fields);

        return new ImageApiEntity($result);
    }
}
