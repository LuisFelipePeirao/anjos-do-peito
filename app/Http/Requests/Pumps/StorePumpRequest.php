<?php

namespace App\Http\Requests\Pumps;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StorePumpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:255', Rule::unique('bomba_leite', 'codigo')],
            'id_modelo' => ['required', 'integer', 'exists:modelos_bombas,id'],
            'num_serie' => ['nullable', 'string', 'max:255'],
            'situacao' => ['required', Rule::in(['disponivel', 'manutencao', 'baixada'])],
            'data_aquisicao' => ['nullable', 'date'],
            'origem' => ['required', Rule::in(['compra', 'doacao', 'emprestimo'])],
            'id_doador' => ['nullable', 'integer', 'exists:doadores,id'],
            'acessorios' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_modelo' => $this->normalizeModel($this->input('id_modelo')),
            'id_doador' => $this->normalizeDonor($this->input('id_doador')),
            'situacao' => $this->normalizeOption($this->input('situacao'), [
                'Disponível' => 'disponivel',
                'Manutenção' => 'manutencao',
                'Inativa' => 'baixada',
            ]),
            'origem' => $this->normalizeOption($this->input('origem'), [
                'Compra' => 'compra',
                'Doação' => 'doacao',
                'Empréstimo' => 'emprestimo',
            ]),
        ]);
    }

    private function normalizeModel(mixed $value): mixed
    {
        if (is_numeric($value) || blank($value)) {
            return $value;
        }

        return DB::table('modelos_bombas')
            ->get(['id', 'fabricante', 'modelo'])
            ->first(fn ($model) => trim($model->fabricante.' '.$model->modelo) === $value)?->id ?? $value;
    }

    private function normalizeDonor(mixed $value): mixed
    {
        if (is_numeric($value) || blank($value) || $value === 'Sem doador vinculado') {
            return blank($value) || $value === 'Sem doador vinculado' ? null : $value;
        }

        return DB::table('doadores')->where('nome', $value)->value('id') ?? $value;
    }

    private function normalizeOption(mixed $value, array $labels): mixed
    {
        return $labels[$value] ?? $value;
    }
}
