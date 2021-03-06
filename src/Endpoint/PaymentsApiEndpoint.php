<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Endpoint;

use Generator;
use Simplia\Api\Entity\PaymentApiEntity;
use Simplia\Api\FieldConfig\PaymentApiFieldConfig;
use Simplia\Api\Request\PaymentApiRequest;

class PaymentsApiEndpoint extends AbstractApiEndpoint {
    /**
     * List payments
     * @param PaymentApiRequest $request
     * @param PaymentApiFieldConfig $fields
     * @param int $batchSize
     * @return Generator|PaymentApiEntity[]
     */
    final public function iterate(
        PaymentApiRequest $request,
        PaymentApiFieldConfig $fields,
        int $batchSize = 100
    ): Generator {
        foreach ($this->iterateList('payments', [], $request, $fields, $batchSize) as $row) {
            yield new PaymentApiEntity($row);
        }
        yield from [];
    }

    /**
     * Get single payment by id
     */
    final public function get(string $id, PaymentApiFieldConfig $fields): ?PaymentApiEntity {
        $result = $this->singleResult('payments/' . $id, [], $fields);

        return $result ? new PaymentApiEntity($result) : null;
    }
}
