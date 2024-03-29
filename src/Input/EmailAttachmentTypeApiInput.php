<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\Input;

class EmailAttachmentTypeApiInput extends AbstractApiInput {
    public function setName(string $name): self {
        $this->params['name'] = $name;

        return $this;
    }

    public function setBodyBase64(string $bodyBase64): self {
        $this->params['body_base64'] = $bodyBase64;

        return $this;
    }

    public function setContentType(string $contentType): self {
        $this->params['content_type'] = $contentType;

        return $this;
    }
}
