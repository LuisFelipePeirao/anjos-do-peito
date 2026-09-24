<?php

namespace App\Http\Requests\Beneficiaries;

class UpdateChildRequest extends StoreChildRequest
{
    public function messages(): array
    {
        return parent::messages();
    }
}
