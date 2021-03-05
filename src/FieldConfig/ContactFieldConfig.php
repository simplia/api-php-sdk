<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

declare(strict_types=1);

namespace Simplia\Api\FieldConfig;

class ContactFieldConfig extends AbstractFieldConfig {
    public function withId(): self {
        $this->fields['id'] = true;

        return $this;
    }

    public function withFirstName(): self {
        $this->fields['first_name'] = true;

        return $this;
    }

    public function withLastName(): self {
        $this->fields['last_name'] = true;

        return $this;
    }

    public function withStreet(): self {
        $this->fields['street'] = true;

        return $this;
    }

    public function withZip(): self {
        $this->fields['zip'] = true;

        return $this;
    }

    public function withCity(): self {
        $this->fields['city'] = true;

        return $this;
    }

    public function withCountry(): self {
        $this->fields['country'] = true;

        return $this;
    }

    public function withCompanyName(): self {
        $this->fields['company_name'] = true;

        return $this;
    }

    public function withCompanyId(): self {
        $this->fields['company_id'] = true;

        return $this;
    }

    public function withCompanyVatId(): self {
        $this->fields['company_vat_id'] = true;

        return $this;
    }

    public function withPhone(): self {
        $this->fields['phone'] = true;

        return $this;
    }

    public function withEmail(): self {
        $this->fields['email'] = true;

        return $this;
    }
}