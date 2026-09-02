<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SaveAttendanceContinuationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'save_as' => ['required', Rule::in(['draft', 'final'])],
            'confirmed_finalization' => ['nullable', 'boolean'],
            'summary' => ['nullable', 'string', 'max:255'],
            'objective' => ['nullable', 'string'],
            'complaint' => ['nullable', 'string'],
            'evaluation' => ['nullable', 'string'],
            'conduct' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function () {
            if ($this->input('save_as') !== 'final') {
                return;
            }

            if (! $this->boolean('confirmed_finalization')) {
                throw ValidationException::withMessages([
                    'summary' => 'Confirme a finalização do atendimento realizado.',
                ]);
            }

            $requiredFields = ['summary', 'objective', 'complaint', 'evaluation', 'conduct'];
            $errors = [];

            foreach ($requiredFields as $field) {
                if (! filled($this->input($field))) {
                    $errors[$field] = 'Este campo é obrigatório para finalizar o atendimento.';
                }
            }

            if ($errors !== []) {
                throw ValidationException::withMessages($errors);
            }
        });
    }
}
