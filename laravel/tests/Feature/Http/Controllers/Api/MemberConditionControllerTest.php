<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\ConditionStatus;
use App\Models\CalendarMember;
use App\Models\MemberCondition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Tests\TestCase;

class MemberConditionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateCreatesNewRecord()
    {
        $calendarMember = CalendarMember::factory()->create();
        $data = [
            'calendar_member_id' => $calendarMember->id,
            'date' => '2024-08-28',
            'condition' => ConditionStatus::GOOD->value,
        ];

        // Gateのモックでcreateポリシーを許可
        Gate::shouldReceive('authorize')
            ->with('create', MemberCondition::class)
            ->andReturn(true);

        $response = $this->postJson(route('api.v1.member-condition.update'), $data);

        // レスポンスを確認
        $response->assertStatus(201); // リソースが作成された場合
        $response->assertJson([
            'data' => [
                'calendar_member_id' => $data['calendar_member_id'],
                'date' => $data['date'],
                'condition' => $data['condition'],
            ],
        ]);

        // レコードが作成されたことを確認
        $this->assertDatabaseHas('member_conditions', $data);
    }

    public function testUpdateExistingRecord()
    {
        $calendarMember = CalendarMember::factory()->create();
        $existingCondition = MemberCondition::factory()->create([
            'calendar_member_id' => $calendarMember->id,
            'date' => '2024-08-28',
            'condition' => ConditionStatus::POOR->value,
        ]);

        $data = [
            'calendar_member_id' => $calendarMember->id,
            'date' => '2024-08-28',
            'condition' => ConditionStatus::GOOD->value,
        ];

        // Gateのモックでcreateポリシーを許可
        Gate::shouldReceive('authorize')
            ->with('create', MemberCondition::class)
            ->andReturn(true);

        $response = $this->postJson(route('api.v1.member-condition.update'), $data);

        // レスポンスを確認
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'calendar_member_id' => $data['calendar_member_id'],
                'date' => $data['date'],
                'condition' => $data['condition'],
            ],
        ]);

        // レコードが更新されたことを確認
        $this->assertDatabaseHas('member_conditions', [
            'id' => $existingCondition->id,
            'condition' => ConditionStatus::GOOD->value,
        ]);
    }

    public function testDestroy()
    {
        $calendarMember = CalendarMember::factory()->create();
        $condition = MemberCondition::factory()->create([
            'calendar_member_id' => $calendarMember->id,
            'date' => '2024-08-28',
            'condition' => ConditionStatus::GOOD->value,
        ]);

        // Gateのモックでdeleteポリシーを許可
        Gate::shouldReceive('authorize')
            ->with('delete', Mockery::on(function ($arg) use ($condition) {
                return $arg->is($condition);
            }))
            ->andReturn(true);

        $response = $this->deleteJson(route('api.v1.member-condition.destroy'), [
            'calendar_member_id' => $calendarMember->id,
            'date' => '2024-08-28',
        ]);

        // レスポンスを確認
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // レコードが削除されたことを確認
        $this->assertDatabaseMissing('member_conditions', [
            'id' => $condition->id,
        ]);
    }
}
