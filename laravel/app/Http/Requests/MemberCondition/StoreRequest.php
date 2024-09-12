<?php

namespace App\Http\Requests\MemberCondition;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(Gate $gate): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'calendar_member_id' => 'required|exists:calendar_members,id',
            'date' => 'required|date',
            'condition' => [
                'required',
                Rule::in(array_column(\App\Enums\ConditionStatus::cases(), 'value')),
            ],
        ];
    }
}
