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

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do material é obrigatório.',
            'nome.string' => 'O nome do material deve ser um texto válido.',
            'nome.max' => 'O nome do material não pode ter mais de :max caracteres.',
            'id_categoria.required' => 'A categoria do material é obrigatória.',
            'id_categoria.integer' => 'Selecione uma categoria válida.',
            'id_categoria.exists' => 'A categoria selecionada não existe.',
            'unidade_medida.required' => 'A unidade de medida é obrigatória.',
            'unidade_medida.string' => 'A unidade de medida deve ser um texto válido.',
            'unidade_medida.max' => 'A unidade de medida não pode ter mais de :max caracteres.',
            'estoque_minimo.required' => 'O estoque mínimo é obrigatório.',
            'estoque_minimo.integer' => 'O estoque mínimo deve ser um número inteiro.',
            'estoque_minimo.min' => 'O estoque mínimo não pode ser menor que :min.',
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
