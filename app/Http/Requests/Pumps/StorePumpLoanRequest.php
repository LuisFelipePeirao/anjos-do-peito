<?php

namespace App\Http\Requests\Pumps;

use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePumpLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return [
            'contract_type' => ['required', Rule::in(['emprestimo', 'aluguel'])],
            'pump' => ['required', 'integer', Rule::exists('bomba_leite', 'id')->where(fn ($query) => $query->where('situacao', 'disponivel'))],
            'beneficiary' => ['required', 'integer', Rule::exists('beneficiarias', 'id')->where(fn ($query) => $query->where('situacao', 'ativo'))],
            'withdrawn_at' => ['required', 'date'],
            'expected_return' => ['required', 'date', 'after_or_equal:withdrawn_at'],
            'renewal' => ['nullable', Rule::in(['none', '30_days', '60_days'])],
            'monthly_fee' => ['required_if:contract_type,aluguel', 'nullable', 'numeric', 'min:0'],
            'due_day' => ['required_if:contract_type,aluguel', 'nullable', 'integer', 'between:1,31'],
            'billing_method' => ['required_if:contract_type,aluguel', 'nullable', Rule::in(['pix', 'dinheiro', 'boleto'])],
            'first_billing_at' => ['required_if:contract_type,aluguel', 'nullable', 'date', 'after_or_equal:withdrawn_at'],
            'billing_notes' => ['nullable', 'string'],
            'term_signed' => ['required', 'boolean'],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'contract_type' => $this->normalizeOption($this->input('contract_type'), ['Empréstimo' => 'emprestimo', 'Aluguel' => 'aluguel']),
            'pump' => $this->normalizePump($this->input('pump')),
            'beneficiary' => $this->normalizeBeneficiary($this->input('beneficiary')),
            'renewal' => $this->normalizeOption($this->input('renewal'), ['Sem renovação automática' => 'none', 'A cada 30 dias' => '30_days', 'A cada 60 dias' => '60_days']),
            'monthly_fee' => $this->normalizeMoney($this->input('monthly_fee')),
            'billing_method' => $this->normalizeOption($this->input('billing_method'), ['Pix' => 'pix', 'Dinheiro' => 'dinheiro', 'Boleto' => 'boleto']),
            'term_signed' => $this->normalizeBoolean($this->input('term_signed')),
        ]);
    }

    private function normalizePump(mixed $value): mixed
    {
        if (is_numeric($value) || blank($value)) {
            return $value;
        }

        $code = trim(explode(' - ', (string) $value, 2)[0]);

        return BombaLeite::where('codigo', $code)->value('id') ?? $value;
    }

    private function normalizeBeneficiary(mixed $value): mixed
    {
        if (is_numeric($value) || blank($value)) {
            return $value;
        }

        return Beneficiaria::where('nome', $value)->value('id') ?? $value;
    }

    private function normalizeMoney(mixed $value): mixed
    {
        if (blank($value)) {
            return null;
        }

        $value = preg_replace('/[^\d,.-]/', '', (string) $value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return is_numeric($value) ? $value : $this->input('monthly_fee');
    }

    private function normalizeBoolean(mixed $value): mixed
    {
        return $this->normalizeOption($value, ['Sim' => true, 'Não' => false, '1' => true, '0' => false]);
    }

    private function normalizeOption(mixed $value, array $labels): mixed
    {
        return $labels[$value] ?? $value;
    }
}
