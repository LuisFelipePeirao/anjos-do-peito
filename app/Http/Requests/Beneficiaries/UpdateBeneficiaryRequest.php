<?php

namespace App\Http\Requests\Beneficiaries;

class UpdateBeneficiaryRequest extends StoreBeneficiaryRequest
{
    protected function beneficiaryIdToIgnore(): ?int
    {
        return $this->route('beneficiaria')?->id;
    }
}
