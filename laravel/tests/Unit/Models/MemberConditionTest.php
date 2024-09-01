<?php

use App\Enums\ConditionStatus;
use App\Models\CalendarMember;
use App\Models\MemberCondition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberConditionTest extends TestCase
{
    use RefreshDatabase;

    public function testメンバーとの関連を確認する()
    {
        $memberCondition = MemberCondition::factory()->create();

        $this->assertInstanceOf(CalendarMember::class, $memberCondition->calendarMember);
        $this->assertEquals($memberCondition->calendar_member_id, $memberCondition->calendarMember->id);
    }

    public function test正しい調子を保存できるか確認する()
    {
        $memberCondition = MemberCondition::factory()->create(['condition' => ConditionStatus::GOOD]);

        $this->assertEquals(ConditionStatus::GOOD, $memberCondition->condition);
        $this->assertDatabaseHas('member_conditions', [
            'id' => $memberCondition->id,
            'condition' => ConditionStatus::GOOD->value,
        ]);
    }

    public function test日付とメンバーIDを指定して条件を保存できるか確認する()
    {
        $member = CalendarMember::factory()->create();
        $memberCondition = MemberCondition::factory()->create([
            'calendar_member_id' => $member->id,
            'date' => '2024-08-20',
            'condition' => ConditionStatus::POOR,
        ]);

        $this->assertEquals('2024-08-20', $memberCondition->date);
        $this->assertEquals($member->id, $memberCondition->calendar_member_id);
        $this->assertEquals(ConditionStatus::POOR, $memberCondition->condition);

        $this->assertDatabaseHas('member_conditions', [
            'calendar_member_id' => $member->id,
            'date' => '2024-08-20',
            'condition' => ConditionStatus::POOR->value,
        ]);
    }

    public function testメンバー削除時に関連する条件が削除されるか確認する()
    {
        $member = CalendarMember::factory()->create();
        $memberCondition = MemberCondition::factory()->create(['calendar_member_id' => $member->id]);

        $member->delete();

        $this->assertDatabaseMissing('member_conditions', ['id' => $memberCondition->id]);
    }
}
