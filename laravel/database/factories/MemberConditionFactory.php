<?php

namespace Database\Factories;

use App\Enums\ConditionStatus;
use App\Models\CalendarMember;
use App\Models\MemberCondition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalendarMember>
 */
class MemberConditionFactory extends Factory
{
    protected $model = MemberCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'calendar_member_id' => CalendarMember::factory(),
            'date' => Carbon::today(),
            'condition' => $this->faker->randomElement(ConditionStatus::all()),
        ];
    }
}
