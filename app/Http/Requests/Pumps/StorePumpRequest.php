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

    public function messages(): array
    {
        return [
            'codigo.required' => 'O código da bomba é obrigatório.',
            'codigo.string' => 'O código da bomba deve ser um texto válido.',
            'codigo.max' => 'O código da bomba não pode ter mais de :max caracteres.',
            'codigo.unique' => 'Já existe uma bomba com este código.',
            'id_modelo.required' => 'O modelo da bomba é obrigatório.',
            'id_modelo.integer' => 'Selecione um modelo válido.',
            'id_modelo.exists' => 'O modelo selecionado não existe.',
            'num_serie.string' => 'O número de série deve ser um texto válido.',
            'num_serie.max' => 'O número de série não pode ter mais de :max caracteres.',
            'situacao.required' => 'A situação da bomba é obrigatória.',
            'situacao.in' => 'Selecione uma situação válida.',
            'data_aquisicao.date' => 'Informe uma data de aquisição válida.',
            'origem.required' => 'A origem da bomba é obrigatória.',
            'origem.in' => 'Selecione uma origem válida.',
            'id_doador.integer' => 'Selecione um doador válido.',
            'id_doador.exists' => 'O doador selecionado não existe.',
            'acessorios.string' => 'Os acessórios devem ser um texto válido.',
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
