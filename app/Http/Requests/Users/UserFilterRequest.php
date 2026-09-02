<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['all', 'active', 'inactive'])],
            'profile' => ['nullable', Rule::in(['all', ...StoreUserRequest::profiles()])],
        ];
    }

    public function filters(): array
    {
        return [
            'search' => $this->string('q')->trim()->toString(),
            'status' => $this->string('status', 'all')->toString(),
            'profile' => $this->string('profile', 'all')->toString(),
        ];
    }
}
