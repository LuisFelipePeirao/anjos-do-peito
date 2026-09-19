<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceCategoryRequest extends FormRequest
{
    protected $errorBag = 'attendanceCategory';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255', Rule::unique('categorias_atendimento', 'nome')->ignore($this->route('category'))],
            'descricao' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da categoria é obrigatório.',
            'nome.string' => 'O nome da categoria deve ser um texto válido.',
            'nome.max' => 'O nome da categoria não pode ter mais de :max caracteres.',
            'nome.unique' => 'Já existe uma categoria com este nome.',
            'descricao.string' => 'A descrição deve ser um texto válido.',
        ];
    }
}
