<?php

namespace App\Http\Requests\Beneficiaries;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBeneficiaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', (string) $this->input('cpf')),
            'cep' => preg_replace('/\D/', '', (string) $this->input('cep')) ?: null,
        ]);
    }

    public function rules(): array
    {
        $addressStarted = collect(['cep', 'logradouro', 'bairro', 'cidade', 'uf', 'numero', 'complemento'])
            ->contains(fn (string $field) => filled($this->input($field)));

        return [
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'regex:/^\d{11}$/', fn (string $attribute, string $value, $fail) => self::isValidCpf($value) ?: $fail('Informe um CPF válido.'), Rule::unique('beneficiarias', 'cpf')->ignore($this->beneficiaryIdToIgnore())],
            'email' => ['required', 'email', 'max:255'],
            'telefone' => ['required', 'string', 'max:30'],
            'telefone_alternativo' => ['nullable', 'string', 'max:30'],
            'origem_cadastro' => ['required', Rule::in(array_keys(self::origins()))],
            'cep' => [Rule::requiredIf($addressStarted), 'nullable', 'string', 'regex:/^\d{8}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => [Rule::requiredIf($addressStarted), 'nullable', 'string', 'max:255'],
            'uf' => [Rule::requiredIf($addressStarted), 'nullable', Rule::in(array_keys(self::states()))],
            'numero' => ['nullable', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
        ];
    }

    public static function origins(): array
    {
        return ['busca_espontanea' => 'Busca espontânea', 'encaminhamento_ubs' => 'Encaminhamento UBS', 'indicacao' => 'Indicação', 'acao_social' => 'Ação social'];
    }

    public static function states(): array
    {
        return collect(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'])
            ->mapWithKeys(fn (string $state) => [$state => $state])
            ->all();
    }

    protected function beneficiaryIdToIgnore(): ?int
    {
        return null;
    }

    private static function isValidCpf(string $cpf): bool
    {
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($position = 9; $position < 11; $position++) {
            $sum = 0;

            for ($index = 0; $index < $position; $index++) {
                $sum += (int) $cpf[$index] * (($position + 1) - $index);
            }

            $digit = ($sum * 10) % 11;
            $digit = $digit === 10 ? 0 : $digit;

            if ($digit !== (int) $cpf[$position]) {
                return false;
            }
        }

        return true;
    }
}
