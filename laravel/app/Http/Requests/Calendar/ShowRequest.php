<?php

namespace App\Http\Requests\Calendar;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start' => 'nullable|date',
            'end' => 'nullable|date',
        ];
    }

    public function startDate(): CarbonImmutable
    {
        return CarbonImmutable::parse($this->query('start', 'now'))->startOfWeek(CarbonImmutable::MONDAY);
    }

    public function endDate(): CarbonImmutable
    {
        return CarbonImmutable::parse($this->query('end', 'now'))->endOfWeek(CarbonImmutable::SUNDAY);
    }
}
