<?php

namespace Database\Factories;

use App\Models\Calendar;
use App\Models\CalendarMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalendarMember>
 */
class CalendarMemberFactory extends Factory
{
    protected $model = CalendarMember::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'calendar_id' => Calendar::factory(),
            'name' => $this->faker->name,
        ];
    }
}
