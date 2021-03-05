<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Endpoint;

use Generator;
use Simplia\Api\Entity\VoucherApiEntity;
use Simplia\Api\Entity\VoucherLockApiEntity;
use Simplia\Api\FieldConfig\VoucherFieldConfig;
use Simplia\Api\FieldConfig\VoucherLockFieldConfig;
use Simplia\Api\Input\VoucherLockTypeInput;
use Simplia\Api\Request\VoucherLockRequest;

class VoucherLockEndpoint extends AbstractEndpoint {
    /**
     * Lock prepared voucher
     * @param string $code
     */
    final public function acquire(
        VoucherLockTypeInput $input,
        string $code,
        ?VoucherFieldConfig $fields = null
    ): VoucherApiEntity {
        $query = [];
        $query['code'] = $code;
        $result = $this->request('put', 'voucher/lock', $query, $input, $fields);

        return new VoucherApiEntity($result);
    }

    /**
     * Unlock prepared voucher
     * @param string $key
     * @param string $code
     */
    final public function release(string $key, string $code, ?VoucherFieldConfig $fields = null): VoucherApiEntity {
        $query = [];
        $query['key'] = $key;
        $query['code'] = $code;
        $result = $this->request('delete', 'voucher/lock', $query, null, $fields);

        return new VoucherApiEntity($result);
    }

    /**
     * List voucher locks
     * @param string $key
     * @param VoucherLockRequest $request
     * @param VoucherLockFieldConfig $fields
     * @param int $batchSize
     * @return Generator|VoucherLockApiEntity[]
     */
    final public function iterate(
        string $key,
        VoucherLockRequest $request,
        VoucherLockFieldConfig $fields,
        int $batchSize = 100
    ): Generator {
        $query = [];
        $query['key'] = $key;
        foreach ($this->iterateList('voucher/locks', $query, $request, $fields, $batchSize) as $row) {
            yield new VoucherLockApiEntity($row);
        }
        yield from [];
    }
}