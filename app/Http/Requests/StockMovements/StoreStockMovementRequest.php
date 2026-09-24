<?php

namespace App\Http\Requests\StockMovements;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStockMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        $type = $this->input('tipo');

        return [
            'tipo' => ['required', Rule::in(['entrada', 'saida', 'ajuste'])],
            'id_doador' => ['nullable', 'integer', 'exists:doadores,id'],
            'id_beneficiaria' => [Rule::requiredIf($type === 'saida'), 'nullable', 'integer', 'exists:beneficiarias,id'],
            'id_material' => [Rule::requiredIf($type === 'ajuste'), 'nullable', 'integer', 'exists:materiais,id'],
            'operacao' => [Rule::requiredIf($type === 'ajuste'), 'nullable', Rule::in(['adicionar', 'subtrair'])],
            'data_hora' => ['required', 'date'],
            'situacao' => ['nullable', 'string', Rule::when($type === 'entrada', Rule::in(['recebida', 'cancelada'])), Rule::when($type === 'saida', Rule::in(['pendente', 'entregue', 'cancelada']))],
            'observacao' => [Rule::requiredIf($type === 'ajuste'), 'nullable', 'string'],
            'items' => [Rule::requiredIf(in_array($type, ['entrada', 'saida'], true)), 'array', 'min:1'],
            'items.*.id_material' => ['required_with:items', 'integer', 'exists:materiais,id'],
            'items.*.quantidade' => ['required_with:items', 'integer', 'min:1'],
            'items.*.observacao' => ['nullable', 'string'],
            'quantidade' => [Rule::requiredIf($type === 'ajuste'), 'nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required' => 'O tipo de movimentação é obrigatório.',
            'tipo.in' => 'Selecione um tipo de movimentação válido.',
            'id_doador.integer' => 'Selecione um doador válido.',
            'id_doador.exists' => 'O doador selecionado não existe.',
            'id_beneficiaria.required' => 'A beneficiária é obrigatória para uma saída.',
            'id_beneficiaria.integer' => 'Selecione uma beneficiária válida.',
            'id_beneficiaria.exists' => 'A beneficiária selecionada não existe.',
            'id_material.required' => 'O material é obrigatório para um ajuste.',
            'id_material.integer' => 'Selecione um material válido.',
            'id_material.exists' => 'O material selecionado não existe.',
            'operacao.required' => 'A operação é obrigatória para um ajuste.',
            'operacao.in' => 'Selecione uma operação válida.',
            'data_hora.required' => 'A data e horário da movimentação são obrigatórios.',
            'data_hora.date' => 'Informe uma data e horário válidos.',
            'situacao.string' => 'A situação deve ser um texto válido.',
            'situacao.in' => 'Selecione uma situação válida para esta movimentação.',
            'observacao.required' => 'A observação é obrigatória para um ajuste.',
            'observacao.string' => 'A observação deve ser um texto válido.',
            'items.required' => 'Inclua ao menos um item na movimentação.',
            'items.array' => 'Os itens da movimentação são inválidos.',
            'items.min' => 'Inclua ao menos um item na movimentação.',
            'items.*.id_material.required_with' => 'Selecione o material do item.',
            'items.*.id_material.integer' => 'Selecione um material válido.',
            'items.*.id_material.exists' => 'O material selecionado não existe.',
            'items.*.quantidade.required_with' => 'Informe a quantidade do item.',
            'items.*.quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'items.*.quantidade.min' => 'A quantidade deve ser no mínimo :min.',
            'items.*.observacao.string' => 'A observação do item deve ser um texto válido.',
            'quantidade.required' => 'Informe a quantidade para o ajuste.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade deve ser no mínimo :min.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! in_array($this->input('tipo'), ['entrada', 'saida'], true)) {
            return;
        }

        $this->merge([
            'items' => collect($this->input('items', []))
                ->filter(fn ($item) => filled($item['id_material'] ?? null))
                ->values()
                ->all(),
        ]);
    }
}
