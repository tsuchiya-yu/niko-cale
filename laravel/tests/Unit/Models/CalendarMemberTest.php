<?php

use App\Models\Calendar;
use App\Models\CalendarMember;
use App\Models\MemberCondition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarMemberTest extends TestCase
{
    use RefreshDatabase;

    public function testカレンダーの関連を確認する()
    {
        $calendar = Calendar::factory()->create();
        $member = CalendarMember::factory()->create(['calendar_id' => $calendar->id]);

        $this->assertInstanceOf(Calendar::class, $member->calendar);
        $this->assertEquals($calendar->id, $member->calendar->id);
    }

    public function testメンバーの調子の関連を確認する()
    {
        $member = CalendarMember::factory()->create();
        MemberCondition::factory()->count(3)->create(['calendar_member_id' => $member->id]);

        $this->assertCount(3, $member->conditions);
        $this->assertInstanceOf(MemberCondition::class, $member->conditions->first());
    }

    public function testメンバー削除時に関連する調子も削除されるか確認する()
    {
        $member = CalendarMember::factory()->create();
        MemberCondition::factory()->count(3)->create(['calendar_member_id' => $member->id]);

        $member->delete();

        $this->assertDatabaseMissing('calendar_members', ['id' => $member->id]);
        $this->assertDatabaseMissing('member_conditions', ['calendar_member_id' => $member->id]);
    }

    public function testメンバーが正しく保存されるか確認する()
    {
        $calendar = Calendar::factory()->create();
        $member = CalendarMember::factory()->create(['calendar_id' => $calendar->id, 'name' => 'テストメンバー']);

        $this->assertDatabaseHas('calendar_members', [
            'id' => $member->id,
            'calendar_id' => $calendar->id,
            'name' => 'テストメンバー',
        ]);
    }
}
