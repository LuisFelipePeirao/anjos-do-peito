<?php

namespace App\Http\Requests\Attendances;

use App\Http\Requests\Beneficiaries\StoreBeneficiaryRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLocationRequest extends FormRequest
{
    protected $errorBag = 'location';

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cep' => preg_replace('/\D/', '', (string) $this->input('cep')) ?: null,
        ]);
    }

    public function rules(): array
    {
        $addressStarted = collect(['cep', 'logradouro', 'bairro', 'cidade', 'uf', 'numero', 'complemento'])
            ->contains(fn (string $field) => filled($this->input($field)));

        return [
            'nome' => ['required', 'string', 'max:255', Rule::unique('locais_atendimento', 'nome')->ignore($this->route('location'))],
            'descricao' => ['nullable', 'string'],
            'cep' => [Rule::requiredIf($addressStarted), 'nullable', 'string', 'regex:/^\d{8}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => [Rule::requiredIf($addressStarted), 'nullable', 'string', 'max:255'],
            'uf' => [Rule::requiredIf($addressStarted), 'nullable', Rule::in(array_keys(StoreBeneficiaryRequest::states()))],
            'numero' => ['nullable', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
        ];
    }
}
