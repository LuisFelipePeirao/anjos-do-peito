<?php

namespace App\Http\Requests\Attendances;

class UpdateAttendanceCategoryRequest extends StoreAttendanceCategoryRequest
{
    public function messages(): array
    {
        return parent::messages();
    }
}
