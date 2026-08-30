<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonorRequest extends FormRequest
{
    protected $errorBag = 'donor';

    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'telefone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'observacao' => ['nullable', 'string'],
        ];
    }
}
