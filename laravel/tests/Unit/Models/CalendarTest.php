<?php

use App\Models\Calendar;
use App\Models\CalendarMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function testカレンダーにメンバーを追加できる()
    {
        $calendar = Calendar::factory()->create([
            'team_name' => '開発チーム',
            'memo' => 'Laravelプロジェクトに取り組んでいるチーム',
        ]);

        CalendarMember::factory()->count(3)->create(['calendar_id' => $calendar->id]);

        $this->assertEquals('開発チーム', $calendar->team_name);
        $this->assertCount(3, $calendar->members);
    }

    public function testメンバーの名前を文字列で取得できる()
    {
        $calendar = Calendar::factory()->create();

        $members = CalendarMember::factory()->count(3)->create(['calendar_id' => $calendar->id]);

        $expectedNames = $members->pluck('name')->implode("\n");

        $this->assertEquals($expectedNames, $calendar->getMemberNames());
    }

    public function testメンバーの名前をカスタムの区切り文字で取得できる()
    {
        $calendar = Calendar::factory()->create();

        $members = CalendarMember::factory()->count(3)->create(['calendar_id' => $calendar->id]);

        $expectedNames = $members->pluck('name')->implode(', ');

        $this->assertEquals($expectedNames, $calendar->getMemberNames(', '));
    }
}
