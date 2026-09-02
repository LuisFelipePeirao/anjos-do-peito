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

    public static function sexOptions(): array
    {
        return ['masculino' => 'Masculino', 'feminino' => 'Feminino', 'indefinido' => 'Prefiro não informar'];
    }
}
