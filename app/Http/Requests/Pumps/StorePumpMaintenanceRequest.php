<?php

namespace App\Http\Requests\Pumps;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePumpMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['preventiva', 'corretiva', 'higienizacao'])],
            'started_at' => ['required', 'date'],
            'status' => ['required', Rule::in(['aberta', 'em_andamento'])],
            'description' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Selecione o tipo de manutenção.',
            'type.in' => 'Selecione um tipo de manutenção válido.',
            'started_at.required' => 'Informe a data e hora de início.',
            'started_at.date' => 'Informe uma data e hora de início válida.',
            'status.required' => 'Selecione a situação inicial.',
            'status.in' => 'Selecione uma situação inicial válida.',
            'description.required' => 'Descreva a manutenção.',
            'description.string' => 'A descrição deve ser um texto válido.',
            'notes.string' => 'As observações devem ser um texto válido.',
        ];
    }
}
