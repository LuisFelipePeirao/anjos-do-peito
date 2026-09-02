<?php

namespace App\Http\Requests\Pumps;

use App\Models\BombaLeite;
use Illuminate\Foundation\Http\FormRequest;

class RenewPumpLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        /** @var BombaLeite|null $pump */
        $pump = $this->route('pump');
        $currentLoan = $pump?->cessoes()
            ->whereIn('situacao', ['ativa', 'atrasada'])
            ->latest('data_retirada')
            ->first();
        $minimumDate = $currentLoan?->data_prevista_devolucao?->isFuture()
            ? $currentLoan->data_prevista_devolucao->toDateString()
            : now()->toDateString();

        return [
            'expires_at' => ['required', 'date', 'after:'.$minimumDate],
        ];
    }

    public function messages(): array
    {
        return [
            'expires_at.after' => 'Informe uma nova data posterior ao vencimento atual ou à data de hoje.',
        ];
    }
}
