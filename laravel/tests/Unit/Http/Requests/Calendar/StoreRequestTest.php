<?php

namespace Tests\Unit\Http\Requests\Calendar;

use App\Http\Requests\Calendar\StoreRequest;
use App\Models\Calendar;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StoreRequestTest extends TestCase
{
    #[DataProvider('provideValidationData')]
    public function testValidationRules($data, $expected)
    {
        $request = new StoreRequest;
        $validator = Validator::make($data, $request->rules());

        $this->assertEquals($expected, $validator->passes());
    }

    public function testMembersArray()
    {
        $data = ['members' => "太郎\n花子\n次郎"];
        $request = StoreRequest::create('/store', 'POST', $data);

        $expected = [
            ['name' => '太郎'],
            ['name' => '花子'],
            ['name' => '次郎'],
        ];

        $this->assertEquals($expected, $request->membersArray());
    }

    public function testMakeCalendar()
    {
        $validatedData = [
            'team_name' => 'チーム太郎',
            'memo' => '太郎チームのメモ',
            'members' => '太郎,花子,次郎',
        ];

        // `validated` メソッドのみをモックして、他のメソッドは通常通り動作させる
        $request = \Mockery::mock(StoreRequest::class)->makePartial();

        $request->shouldReceive('validated')
            ->once()
            ->andReturn($validatedData);

        $calendar = $request->makeCalendar();

        // Calendarオブジェクトが正しく作成されたことを確認
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertEquals($validatedData['team_name'], $calendar->team_name);
        $this->assertEquals($validatedData['memo'], $calendar->memo);
    }

    public static function provideValidationData(): array
    {
        return [
            'OK' => [
                [
                    'team_name' => 'チーム太郎',
                    'memo' => '太郎チームのメモ',
                    'members' => '太郎,花子,次郎',
                ],
                true,
            ],
            'チーム名なし' => [
                [
                    'memo' => '太郎チームのメモ',
                    'members' => '太郎,花子,次郎',
                ],
                false,
            ],
            'メンバーなし' => [
                [
                    'team_name' => 'チーム太郎',
                    'memo' => '太郎チームのメモ',
                ],
                false,
            ],
            'チーム名が長い' => [
                [
                    'team_name' => str_repeat('A', 256),
                    'memo' => '太郎チームのメモ',
                    'members' => '太郎,花子,次郎',
                ],
                false,
            ],
            'メモが長い' => [
                [
                    'team_name' => 'チーム太郎',
                    'memo' => str_repeat('A', 1001),
                    'members' => '太郎,花子,次郎',
                ],
                false,
            ],
        ];
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
