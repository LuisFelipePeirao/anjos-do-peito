<?php

namespace App\Http\Requests;

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
