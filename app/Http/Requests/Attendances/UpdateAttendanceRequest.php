<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Validation\Rule;

class UpdateAttendanceRequest extends StoreAttendanceRequest
{
    public function rules(): array
    {
        $attendance = $this->route('attendance');
        $rules = parent::rules();
        $rules['status'] = ['required', Rule::in([$attendance->situacao])];

        return $rules;
    }
}
