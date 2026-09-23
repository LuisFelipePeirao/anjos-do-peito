<?php

namespace App\Http\Requests\Pumps;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRentalPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageAttendances() ?? false;
    }

    public function rules(): array
    {
        return ['paid_at' => ['required', 'date'], 'notes' => ['nullable', 'string']];
    }
}
