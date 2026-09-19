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

    public function messages(): array
    {
        return [
            'q.string' => 'A busca deve ser um texto válido.',
            'q.max' => 'A busca não pode ter mais de :max caracteres.',
            'status.in' => 'Selecione uma situação válida.',
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
