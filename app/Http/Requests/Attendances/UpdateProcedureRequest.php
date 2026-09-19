<?php

namespace App\Http\Requests\Attendances;

class UpdateProcedureRequest extends StoreProcedureRequest
{
    public function messages(): array
    {
        return parent::messages();
    }
}
