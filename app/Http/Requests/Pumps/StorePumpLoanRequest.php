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
            'monthly_fee' => ['required_if:contract_type,aluguel', 'nullable', 'numeric', 'min:0'],
            'due_day' => ['required_if:contract_type,aluguel', 'nullable', 'integer', 'between:1,31'],
            'billing_method' => ['required_if:contract_type,aluguel', 'nullable', Rule::in(['pix', 'dinheiro', 'boleto'])],
            'first_billing_at' => ['required_if:contract_type,aluguel', 'nullable', 'date', 'after_or_equal:withdrawn_at'],
            'billing_notes' => ['nullable', 'string'],
            'term_signed' => ['required', 'boolean'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'contract_type.required' => 'O tipo de contrato é obrigatório.',
            'contract_type.in' => 'Selecione um tipo de contrato válido.',
            'pump.required' => 'A bomba de leite é obrigatória.',
            'pump.integer' => 'Selecione uma bomba de leite válida.',
            'pump.exists' => 'A bomba selecionada não está disponível.',
            'beneficiary.required' => 'A beneficiária é obrigatória.',
            'beneficiary.integer' => 'Selecione uma beneficiária válida.',
            'beneficiary.exists' => 'A beneficiária selecionada não está disponível.',
            'withdrawn_at.required' => 'A data de retirada é obrigatória.',
            'withdrawn_at.date' => 'Informe uma data de retirada válida.',
            'expected_return.required' => 'A data prevista de devolução é obrigatória.',
            'expected_return.date' => 'Informe uma data prevista de devolução válida.',
            'expected_return.after_or_equal' => 'A devolução deve ser na mesma data ou após a retirada.',
            'monthly_fee.required_if' => 'Informe o valor mensal para contratos de aluguel.',
            'monthly_fee.numeric' => 'O valor mensal deve ser numérico.',
            'monthly_fee.min' => 'O valor mensal não pode ser menor que :min.',
            'due_day.required_if' => 'Informe o dia de vencimento para contratos de aluguel.',
            'due_day.integer' => 'O dia de vencimento deve ser um número inteiro.',
            'due_day.between' => 'O dia de vencimento deve estar entre :min e :max.',
            'billing_method.required_if' => 'Informe a forma de cobrança para contratos de aluguel.',
            'billing_method.in' => 'Selecione uma forma de cobrança válida.',
            'first_billing_at.required_if' => 'Informe a data da primeira cobrança para contratos de aluguel.',
            'first_billing_at.date' => 'Informe uma data de cobrança válida.',
            'first_billing_at.after_or_equal' => 'A primeira cobrança deve ser na mesma data ou após a retirada.',
            'billing_notes.string' => 'As observações de cobrança devem ser um texto válido.',
            'term_signed.required' => 'Confirme a assinatura do termo.',
            'term_signed.boolean' => 'A confirmação do termo é inválida.',
            'notes.string' => 'As observações devem ser um texto válido.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'contract_type' => $this->normalizeOption($this->input('contract_type'), ['Empréstimo' => 'emprestimo', 'Aluguel' => 'aluguel']),
            'pump' => $this->normalizePump($this->input('pump')),
            'beneficiary' => $this->normalizeBeneficiary($this->input('beneficiary')),
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
