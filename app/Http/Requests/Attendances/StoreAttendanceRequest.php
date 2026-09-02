<?php

namespace App\Http\Requests\Attendances;

use App\Models\Crianca;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isDraft = $this->input('save_as') === 'draft';
        $required = $isDraft ? 'nullable' : 'required';

        return [
            'save_as' => ['required', Rule::in(['draft', 'final'])],
            'confirmed_finalization' => ['nullable', 'boolean'],
            'date' => [$required, 'date'],
            'time' => [$required, 'date_format:H:i'],
            'duration' => [$isDraft ? 'nullable' : 'required', Rule::in(array_keys(self::durations()))],
            'status' => ['required', Rule::in(['agendado', 'realizado'])],
            'modality' => [$required, Rule::in(array_keys(self::modalities()))],
            'location' => [$required, 'integer', 'exists:locais_atendimento,id'],
            'beneficiary' => ['required', 'integer', 'exists:beneficiarias,id'],
            'child' => ['nullable', 'integer', 'exists:criancas,id'],
            'professional' => [$required, 'integer', Rule::exists('usuarios', 'id')->where(fn ($query) => $query->whereIn('perfil', ['administrador', 'enfermeira']))],
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
            $data = $this->validated();

            if (! isset($data['beneficiary'])) {
                return;
            }

            $this->ensureChildBelongsToBeneficiary($data['child'] ?? null, (int) $data['beneficiary']);

            if (($data['save_as'] ?? null) === 'draft') {
                return;
            }

            if (($data['status'] ?? null) === 'realizado') {
                if (! $this->boolean('confirmed_finalization')) {
                    throw ValidationException::withMessages([
                        'status' => 'Confirme a finalização do atendimento realizado.',
                    ]);
                }

                $errors = [];

                foreach (['summary', 'objective', 'complaint', 'evaluation', 'conduct'] as $field) {
                    if (! filled($this->input($field))) {
                        $errors[$field] = 'Este campo é obrigatório para finalizar o atendimento.';
                    }
                }

                if ($errors !== []) {
                    throw ValidationException::withMessages($errors);
                }
            }
        });
    }

    public static function modalities(): array
    {
        return ['presencial' => 'Presencial', 'remota' => 'Remota'];
    }

    public static function durations(): array
    {
        return ['00:30' => '30 minutos', '00:45' => '45 minutos', '01:00' => '60 minutos', '01:30' => '90 minutos'];
    }

    private function ensureChildBelongsToBeneficiary(?int $childId, int $beneficiaryId): void
    {
        if ($childId !== null && ! Crianca::whereKey($childId)->where('id_beneficiaria', $beneficiaryId)->exists()) {
            throw ValidationException::withMessages([
                'child' => 'A criança selecionada não pertence à beneficiária informada.',
            ]);
        }
    }
}
