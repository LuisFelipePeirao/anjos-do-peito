<?php

namespace App\Http\Requests;

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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'items' => collect($this->input('items', []))->filter(fn ($item) => filled($item['id_material'] ?? null))->values()->all(),
        ]);
    }
}
