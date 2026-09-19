<?php

namespace App\Http\Requests\Donations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDistributionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return [
            'id_beneficiaria' => ['required', 'integer', 'exists:beneficiarias,id'],
            'data_hora' => ['required', 'date'],
            'situacao' => ['required', Rule::in(['pendente', 'entregue', 'cancelada'])],
            'observacao' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id_material' => ['required', 'integer', 'exists:materiais,id'],
            'items.*.quantidade' => ['required', 'integer', 'min:1'],
            'items.*.observacao' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_beneficiaria.required' => 'A beneficiária é obrigatória.',
            'id_beneficiaria.integer' => 'Selecione uma beneficiária válida.',
            'id_beneficiaria.exists' => 'A beneficiária selecionada não existe.',
            'data_hora.required' => 'A data e horário da distribuição são obrigatórios.',
            'data_hora.date' => 'Informe uma data e horário válidos.',
            'situacao.required' => 'A situação da distribuição é obrigatória.',
            'situacao.in' => 'Selecione uma situação de distribuição válida.',
            'observacao.string' => 'A observação deve ser um texto válido.',
            'items.required' => 'Inclua ao menos um item na distribuição.',
            'items.array' => 'Os itens da distribuição são inválidos.',
            'items.min' => 'Inclua ao menos um item na distribuição.',
            'items.*.id_material.required' => 'Selecione o material do item.',
            'items.*.id_material.integer' => 'Selecione um material válido.',
            'items.*.id_material.exists' => 'O material selecionado não existe.',
            'items.*.quantidade.required' => 'Informe a quantidade do item.',
            'items.*.quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'items.*.quantidade.min' => 'A quantidade deve ser no mínimo :min.',
            'items.*.observacao.string' => 'A observação do item deve ser um texto válido.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'items' => collect($this->input('items', []))->filter(fn ($item) => filled($item['id_material'] ?? null))->values()->all(),
        ]);
    }
}
