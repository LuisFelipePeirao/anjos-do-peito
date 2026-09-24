<?php

namespace App\Http\Requests\Users;

class UpdateUserRequest extends StoreUserRequest
{
    public function messages(): array
    {
        return parent::messages();
    }

    protected function passwordRule(): string
    {
        return 'nullable';
    }

    protected function userIdToIgnore(): ?int
    {
        return $this->route('usuario')?->id;
    }
}
