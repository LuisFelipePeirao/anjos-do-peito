<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLocationRequest extends FormRequest
{
    protected $errorBag = 'location';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255', Rule::unique('locais_atendimento', 'nome')],
            'descricao' => ['nullable', 'string'],
        ];
    }
}
