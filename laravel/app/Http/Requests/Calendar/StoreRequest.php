<?php

namespace App\Http\Requests\Calendar;

use App\Models\Calendar;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(Gate $gate): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'team_name' => 'required|string|max:255',
            'memo' => 'nullable|string|max:1000',
            'members' => 'required|string',
        ];
    }

    /**
     * メンバー名を改行で分割して配列に変換
     */
    public function membersArray(): array
    {
        return array_map(fn ($name) => ['name' => $name], array_filter(preg_split('/\r\n|\r|\n/', $this->input('members'))));
    }

    /**
     * カレンダーオブジェクトを作成
     */
    public function makeCalendar(): Calendar
    {
        $calendar = new Calendar($this->validated());

        return $calendar;
    }
}
