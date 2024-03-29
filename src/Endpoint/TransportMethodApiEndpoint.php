<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Endpoint;

use Generator;
use Simplia\Api\Entity\TransportMethodApiEntity;
use Simplia\Api\FieldConfig\TransportMethodApiFieldConfig;
use Simplia\Api\Request\TransportMethodApiRequest;

class TransportMethodApiEndpoint extends AbstractApiEndpoint {
    /**
     * List transport methods
     * @param TransportMethodApiRequest $request
     * @param TransportMethodApiFieldConfig $fields
     * @param int $batchSize
     * @return Generator|TransportMethodApiEntity[]
     */
    final public function iterate(
        TransportMethodApiRequest $request,
        TransportMethodApiFieldConfig $fields,
        int $batchSize = 100
    ): Generator {
        foreach ($this->iterateList('transport-methods', [], $request, $fields, $batchSize) as $row) {
            yield new TransportMethodApiEntity($row);
        }
        yield from [];
    }

    /**
     * Get single transport method
     */
    final public function get(int $id, TransportMethodApiFieldConfig $fields): ?TransportMethodApiEntity {
        $result = $this->singleResult('transport-methods/' . $id, [], $fields);

        return $result ? new TransportMethodApiEntity($result) : null;
    }
}
