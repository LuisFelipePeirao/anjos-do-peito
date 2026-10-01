<?php

namespace App\Http\Requests\Pumps;

use Illuminate\Foundation\Http\FormRequest;

class CancelPumpMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return ['notes' => ['nullable', 'string']];
    }

    public function messages(): array
    {
        return ['notes.string' => 'As observações devem ser um texto válido.'];
    }
}
