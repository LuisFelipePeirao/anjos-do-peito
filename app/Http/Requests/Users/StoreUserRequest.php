<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('usuarios', 'email')->ignore($this->userIdToIgnore())->whereNull('deleted_at')],
            'senha' => [$this->passwordRule(), 'confirmed', Password::defaults()],
            'perfil' => ['required', Rule::in(self::profiles())],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Este campo é obrigatório.',
            'string' => 'Informe um texto válido.',
            'max' => 'Este campo não pode ter mais de :max caracteres.',
            'email.email' => 'O e-mail informado não é válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'senha.confirmed' => 'A confirmação da senha não confere.',
            'senha.password' => 'A senha não atende aos requisitos de segurança.',
            'perfil.in' => 'Selecione um perfil válido.',
        ];
    }

    public static function profiles(): array
    {
        return ['administrador', 'atendente', 'enfermeira'];
    }

    protected function passwordRule(): string
    {
        return 'required';
    }

    protected function userIdToIgnore(): ?int
    {
        return null;
    }
}
