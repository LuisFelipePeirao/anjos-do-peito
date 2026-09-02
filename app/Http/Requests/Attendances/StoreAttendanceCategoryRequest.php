<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceCategoryRequest extends FormRequest
{
    protected $errorBag = 'attendanceCategory';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255', Rule::unique('categorias_atendimento', 'nome')->ignore($this->route('category'))],
            'descricao' => ['nullable', 'string'],
        ];
    }
}
