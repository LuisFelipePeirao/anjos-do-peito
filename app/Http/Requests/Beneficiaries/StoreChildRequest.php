<?php

namespace App\Http\Requests\Beneficiaries;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChildRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date', 'before_or_equal:today'],
            'sexo' => ['required', Rule::in(array_keys(self::sexOptions()))],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Este campo é obrigatório.',
            'string' => 'Informe um texto válido.',
            'max' => 'Este campo não pode ter mais de :max caracteres.',
            'data_nascimento.date' => 'Informe uma data de nascimento válida.',
            'data_nascimento.before_or_equal' => 'A data de nascimento não pode ser futura.',
            'sexo.in' => 'Selecione uma opção de sexo válida.',
        ];
    }

    public static function sexOptions(): array
    {
        return ['masculino' => 'Masculino', 'feminino' => 'Feminino', 'indefinido' => 'Prefiro não informar'];
    }
}
