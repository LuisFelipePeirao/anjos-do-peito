<?php

namespace App\Http\Requests\Pumps;

use App\Models\ManutencaoBomba;
use Illuminate\Foundation\Http\FormRequest;

class FinishPumpMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return [
            'finished_at' => ['required', 'date', 'after_or_equal:maintenance_started_at'],
            'notes' => ['nullable', 'string'],
            'maintenance_started_at' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'finished_at.required' => 'Informe a data e hora de conclusão.',
            'finished_at.date' => 'Informe uma data e hora de conclusão válida.',
            'finished_at.after_or_equal' => 'A conclusão deve ocorrer após o início da manutenção.',
            'notes.string' => 'As observações devem ser um texto válido.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $maintenance = $this->route('maintenance');

        $this->merge([
            'maintenance_started_at' => $maintenance instanceof ManutencaoBomba ? $maintenance->data_inicio?->toDateTimeString() : null,
        ]);
    }
}
