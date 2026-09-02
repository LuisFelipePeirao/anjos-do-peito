<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendanceFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['all', 'agendado', 'em_atendimento', 'realizado', 'cancelado'])],
            'modality' => ['nullable', Rule::in(['all', 'presencial', 'remota'])],
        ];
    }

    public function filters(): array
    {
        return [
            'search' => $this->string('q')->trim()->toString(),
            'status' => $this->string('status', 'all')->toString(),
            'modality' => $this->string('modality', 'all')->toString(),
        ];
    }
}
