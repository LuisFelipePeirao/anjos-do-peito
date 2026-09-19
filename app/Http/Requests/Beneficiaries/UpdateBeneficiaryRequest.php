<?php

namespace App\Http\Requests\Beneficiaries;

class UpdateBeneficiaryRequest extends StoreBeneficiaryRequest
{
    public function messages(): array
    {
        return parent::messages();
    }

    protected function beneficiaryIdToIgnore(): ?int
    {
        return $this->route('beneficiaria')?->id;
    }
}
