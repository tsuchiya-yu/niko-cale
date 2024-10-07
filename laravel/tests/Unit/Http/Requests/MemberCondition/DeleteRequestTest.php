<?php

namespace Tests\Unit\Http\Requests\MemberCondition;

use App\Http\Requests\MemberCondition\DeleteRequest;
use App\Models\CalendarMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DeleteRequestTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('validationDataProvider')]
    public function testValidationRules($data, $expected)
    {
        // テストデータの挿入
        if (isset($data['calendar_member_id']) && $data['calendar_member_id'] === 1) {
            CalendarMember::factory()->create(['id' => 1]);
        }

        $request = new DeleteRequest;
        $validator = Validator::make($data, $request->rules());

        $this->assertEquals($expected, $validator->passes());
    }

    public static function validationDataProvider(): array
    {
        return [
            'OK' => [
                [
                    'calendar_member_id' => 1,
                    'date' => '2024-08-28',
                ],
                true,
            ],
            'calendar_member_idなし' => [
                [
                    'date' => '2024-08-28',
                ],
                false,
            ],
            '不正なcalendar_member_id' => [
                [
                    'calendar_member_id' => 0,
                    'date' => '2024-08-28',
                ],
                false,
            ],
            'dateなし' => [
                [
                    'calendar_member_id' => 1,
                ],
                false,
            ],
            '不正なdate' => [
                [
                    'calendar_member_id' => 1,
                    'date' => 'invalid-date',
                ],
                false,
            ],
        ];
    }
}
