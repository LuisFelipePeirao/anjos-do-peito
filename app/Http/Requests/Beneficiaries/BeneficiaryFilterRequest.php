<?php

namespace App\Http\Requests\Beneficiaries;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BeneficiaryFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['active', 'inactive', 'all'])],
        ];
    }

    public function filters(): array
    {
        return [
            'search' => $this->string('q')->trim()->toString(),
            'status' => $this->string('status', 'active')->toString(),
        ];
    }
}
