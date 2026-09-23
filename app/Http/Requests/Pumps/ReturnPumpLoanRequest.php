<?php

namespace App\Http\Requests\Pumps;

use Illuminate\Foundation\Http\FormRequest;

class ReturnPumpLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return [
            'returned_at' => ['required', 'date'],
            'return_notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'returned_at.required' => 'A data de devolução é obrigatória.',
            'returned_at.date' => 'Informe uma data de devolução válida.',
        ];
    }
}
