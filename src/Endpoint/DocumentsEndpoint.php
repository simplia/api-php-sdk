<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Endpoint;

use Generator;
use Simplia\Api\Entity\DocumentApiEntity;
use Simplia\Api\FieldConfig\DocumentFieldConfig;
use Simplia\Api\Input\DocumentItemPricesInput;
use Simplia\Api\Request\DocumentRequest;

class DocumentsEndpoint extends AbstractEndpoint {
    /**
     * List documents
     * @param DocumentRequest $request
     * @param DocumentFieldConfig $fields
     * @param int $batchSize
     * @return Generator|DocumentApiEntity[]
     */
    final public function iterate(
        DocumentRequest $request,
        DocumentFieldConfig $fields,
        int $batchSize = 100
    ): Generator {
        foreach ($this->iterateList('documents', [], $request, $fields, $batchSize) as $row) {
            yield new DocumentApiEntity($row);
        }
        yield from [];
    }

    /**
     * Get single document by code
     */
    final public function get(string $id, DocumentFieldConfig $fields): ?DocumentApiEntity {
        $result = $this->singleResult('documents/' . $id, [], $fields);

        return $result ? new DocumentApiEntity($result) : null;
    }

    /**
     * Update document item prices
     */
    final public function updateRowsPrices(
        string $id,
        DocumentItemPricesInput $input,
        ?DocumentFieldConfig $fields = null
    ): DocumentApiEntity {
        $result = $this->request('put', 'documents/' . $id . '/rows/price', [], $input, $fields);

        return new DocumentApiEntity($result);
    }
}