<?php

namespace App\Http\Requests\Donations;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'id_categoria' => ['required', 'integer', 'exists:categorias_materiais,id'],
            'unidade_medida' => ['required', 'string', 'max:60'],
            'estoque_minimo' => ['required', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_categoria' => $this->input('id_categoria') ?: null,
            'unidade_medida' => mb_strtolower(trim((string) $this->input('unidade_medida'))),
        ]);
    }
}
