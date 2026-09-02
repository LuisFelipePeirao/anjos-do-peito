<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'section' => ['nullable', Rule::in(['all', 'pumps', 'attendances', 'stock'])],
            'location' => ['nullable', function (string $attribute, mixed $value, \Closure $fail) {
                if ($value === null || $value === '' || $value === 'all' || $value === 'remote' || filter_var($value, FILTER_VALIDATE_INT) !== false) {
                    return;
                }

                $fail('A unidade selecionada é inválida.');
            }],
        ];
    }

    public function filters(): array
    {
        $validated = $this->validated();

        return [
            'start_date' => $validated['start_date'] ?? now()->startOfMonth()->toDateString(),
            'end_date' => $validated['end_date'] ?? now()->endOfMonth()->toDateString(),
            'section' => $validated['section'] ?? 'all',
            'location' => $validated['location'] ?? 'all',
        ];
    }
}
