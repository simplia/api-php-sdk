<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class UserApiInput extends AbstractApiInput {
    public function setId(int $id): self {
        $this->params['id'] = $id;

        return $this;
    }

    public function setPointsFactor(string $pointsFactor): self {
        $this->params['points_factor'] = $pointsFactor;

        return $this;
    }
}
