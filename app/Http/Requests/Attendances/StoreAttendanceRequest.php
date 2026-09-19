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
            'attendance_category' => ['nullable', 'integer', Rule::exists('categorias_atendimento', 'id')->where(fn ($query) => $query->where('ativo', true))],
            'procedure' => ['nullable', 'integer', Rule::exists('procedimentos', 'id')->where(fn ($query) => $query->where('ativo', true))],
            'professional' => [$required, 'integer', Rule::exists('usuarios', 'id')->where(fn ($query) => $query->whereIn('perfil', ['administrador', 'enfermeira']))],
            'summary' => ['nullable', 'string', 'max:255'],
            'objective' => ['nullable', 'string'],
            'complaint' => ['nullable', 'string'],
            'evaluation' => ['nullable', 'string'],
            'conduct' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'save_as.required' => 'Informe como deseja salvar o atendimento.',
            'save_as.in' => 'Selecione uma opção de salvamento válida.',
            'confirmed_finalization.boolean' => 'A confirmação de finalização é inválida.',
            'date.required' => 'A data do atendimento é obrigatória.',
            'date.date' => 'Informe uma data de atendimento válida.',
            'time.required' => 'O horário do atendimento é obrigatório.',
            'time.date_format' => 'Informe um horário válido.',
            'duration.required' => 'A duração prevista é obrigatória.',
            'duration.in' => 'Selecione uma duração válida.',
            'status.required' => 'A situação do atendimento é obrigatória.',
            'status.in' => 'Selecione uma situação de atendimento válida.',
            'modality.required' => 'A modalidade do atendimento é obrigatória.',
            'modality.in' => 'Selecione uma modalidade válida.',
            'location.required' => 'O local do atendimento é obrigatório.',
            'location.integer' => 'Selecione um local válido.',
            'location.exists' => 'O local selecionado não existe.',
            'beneficiary.required' => 'A beneficiária é obrigatória.',
            'beneficiary.integer' => 'Selecione uma beneficiária válida.',
            'beneficiary.exists' => 'A beneficiária selecionada não existe.',
            'child.integer' => 'Selecione uma criança válida.',
            'child.exists' => 'A criança selecionada não existe.',
            'attendance_category.integer' => 'Selecione uma categoria de atendimento válida.',
            'attendance_category.exists' => 'A categoria de atendimento selecionada não está disponível.',
            'procedure.integer' => 'Selecione um procedimento válido.',
            'procedure.exists' => 'O procedimento selecionado não está disponível.',
            'professional.required' => 'O profissional responsável é obrigatório.',
            'professional.integer' => 'Selecione um profissional válido.',
            'professional.exists' => 'O profissional selecionado não está disponível.',
            'summary.max' => 'O resumo não pode ter mais de :max caracteres.',
            'string' => 'Informe um texto válido.',
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

                foreach (['summary', 'objective', 'complaint', 'evaluation', 'conduct', 'attendance_category', 'procedure'] as $field) {
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
