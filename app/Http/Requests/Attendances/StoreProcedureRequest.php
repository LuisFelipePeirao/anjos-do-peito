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
}
