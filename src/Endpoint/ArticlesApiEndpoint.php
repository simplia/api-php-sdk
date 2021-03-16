<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Endpoint;

use Generator;
use Simplia\Api\Entity\ArticleApiEntity;
use Simplia\Api\FieldConfig\ArticleApiFieldConfig;
use Simplia\Api\Request\ArticleApiRequest;

class ArticlesApiEndpoint extends AbstractApiEndpoint {
    /**
     * List articles
     * @param ArticleApiRequest $request
     * @param ArticleApiFieldConfig $fields
     * @param int $batchSize
     * @return Generator|ArticleApiEntity[]
     */
    final public function iterate(
        ArticleApiRequest $request,
        ArticleApiFieldConfig $fields,
        int $batchSize = 100
    ): Generator {
        foreach ($this->iterateList('articles', [], $request, $fields, $batchSize) as $row) {
            yield new ArticleApiEntity($row);
        }
        yield from [];
    }

    /**
     * Get single article
     */
    final public function get(int $id, ArticleApiFieldConfig $fields): ?ArticleApiEntity {
        $result = $this->singleResult('articles/' . $id, [], $fields);

        return $result ? new ArticleApiEntity($result) : null;
    }
}