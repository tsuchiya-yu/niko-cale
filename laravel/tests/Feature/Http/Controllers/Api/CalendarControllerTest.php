<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Calendar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDestroy()
    {
        // カレンダーを作成
        $calendar = Calendar::factory()->create();

        // Gateのモックでdeleteポリシーを許可
        Gate::shouldReceive('authorize')
            ->with('delete', Mockery::on(function ($arg) use ($calendar) {
                return $arg->is($calendar);
            }))
            ->andReturn(true);

        $response = $this->call('DELETE', route('api.v1.calendars.destroy', ['uuid' => $calendar->url]));

        // 期待するレスポンスを確認
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // カレンダーが削除されたことを確認
        $this->assertDatabaseMissing('calendars', ['id' => $calendar->id]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
