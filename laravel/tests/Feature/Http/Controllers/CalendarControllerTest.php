<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Calendar;
use App\Models\CalendarMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $data = [
            'team_name' => '次郎チーム',
            'memo' => '次郎チームのみなさんお願いします！',
            'members' => "次郎\n花子\n健二",
        ];

        Gate::shouldReceive('authorize')
            ->with('create', Calendar::class)
            ->andReturn(true);

        $response = $this->post(route('calendars.store'), $data);

        $response->assertRedirect(route('calendars.stored', ['uuid' => Calendar::first()->url]));

        $this->assertDatabaseHas('calendars', ['team_name' => '次郎チーム']);
        $this->assertDatabaseHas('calendar_members', ['name' => '次郎']);
        $this->assertDatabaseHas('calendar_members', ['name' => '花子']);
        $this->assertDatabaseHas('calendar_members', ['name' => '健二']);
    }

    public function testShow()
    {
        $calendar = Calendar::factory()->has(CalendarMember::factory()->count(3), 'members')->create();

        $response = $this->get(route('calendars.show', ['uuid' => $calendar->url]));

        $response->assertStatus(200);
        $response->assertViewIs('calendars.show');
        $response->assertViewHas('calendar', $calendar);
    }

    public function testEdit()
    {
        $calendar = Calendar::factory()->has(CalendarMember::factory()->count(3), 'members')->create();

        $response = $this->get(route('calendars.edit', ['uuid' => $calendar->url]));

        $response->assertStatus(200);
        $response->assertViewIs('calendars.edit');
        $response->assertViewHas('calendar', $calendar);
    }

    public function testUpdate()
    {
        $calendar = Calendar::factory()->has(CalendarMember::factory()->count(3), 'members')->create();
        $updatedData = [
            'team_name' => 'チーム名更新',
            'memo' => 'メモ更新',
            'members' => "次郎\n永吉\n翔平",
        ];

        $response = $this->put(route('calendars.update', ['uuid' => $calendar->url]), $updatedData);

        $response->assertStatus(200);
        $response->assertViewIs('calendars.show');

        $this->assertDatabaseHas('calendars', ['team_name' => 'チーム名更新']);
        $this->assertDatabaseHas('calendar_members', ['name' => '次郎']);
        $this->assertDatabaseHas('calendar_members', ['name' => '永吉']);
        $this->assertDatabaseHas('calendar_members', ['name' => '翔平']);
        $this->assertDatabaseMissing('calendar_members', ['name' => '花子']);
        $this->assertDatabaseMissing('calendar_members', ['name' => '健二']);
    }
}
