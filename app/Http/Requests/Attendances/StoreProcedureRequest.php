<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProcedureRequest extends FormRequest
{
    protected $errorBag = 'procedure';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255', Rule::unique('procedimentos', 'nome')->ignore($this->route('procedure'))],
            'descricao' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do procedimento é obrigatório.',
            'nome.string' => 'O nome do procedimento deve ser um texto válido.',
            'nome.max' => 'O nome do procedimento não pode ter mais de :max caracteres.',
            'nome.unique' => 'Já existe um procedimento com este nome.',
            'descricao.string' => 'A descrição deve ser um texto válido.',
        ];
    }
}
