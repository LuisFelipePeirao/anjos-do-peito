<?php

namespace App\Http\Requests\Users;

class UpdateUserRequest extends StoreUserRequest
{
    protected function passwordRule(): string
    {
        return 'nullable';
    }

    protected function userIdToIgnore(): ?int
    {
        return $this->route('usuario')?->id;
    }
}
