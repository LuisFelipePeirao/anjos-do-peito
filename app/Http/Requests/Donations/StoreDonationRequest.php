<?php

namespace App\Http\Requests\Donations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return [
            'id_doador' => ['required', 'integer', 'exists:doadores,id'],
            'data_doacao' => ['required', 'date'],
            'situacao' => ['required', Rule::in(['recebida', 'cancelada'])],
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
            'id_doador.required' => 'O doador é obrigatório.',
            'id_doador.integer' => 'Selecione um doador válido.',
            'id_doador.exists' => 'O doador selecionado não existe.',
            'data_doacao.required' => 'A data da doação é obrigatória.',
            'data_doacao.date' => 'Informe uma data de doação válida.',
            'situacao.required' => 'A situação da doação é obrigatória.',
            'situacao.in' => 'Selecione uma situação de doação válida.',
            'observacao.string' => 'A observação deve ser um texto válido.',
            'items.required' => 'Inclua ao menos um item na doação.',
            'items.array' => 'Os itens da doação são inválidos.',
            'items.min' => 'Inclua ao menos um item na doação.',
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
