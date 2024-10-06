<?php

namespace Tests\Unit\Http\Requests\Calendar;

use App\Http\Requests\Calendar\ShowRequest;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ShowRequestTest extends TestCase
{
    #[DataProvider('provideStartDateCases')]
    public function testStartDateの検証($input, $expected)
    {
        $request = new ShowRequest;
        $request->query->set('start', $input);

        $this->assertEquals($expected, $request->startDate());
    }

    #[DataProvider('provideEndDateCases')]
    public function testEndDateの検証($input, $expected)
    {
        $request = new ShowRequest;
        $request->query->set('end', $input);

        $this->assertEquals($expected, $request->endDate());
    }

    #[DataProvider('provideRulesCases')]
    public function testRulesの検証($data, $expected)
    {
        $request = new ShowRequest;
        $validator = Validator::make($data, $request->rules());

        $this->assertEquals($expected, $validator->passes());
    }

    public static function provideStartDateCases(): array
    {
        return [
            '開始日がnullの場合' => [null, CarbonImmutable::now('JST')->startOfWeek(CarbonImmutable::MONDAY)],
            '開始日が指定された場合' => ['2023-08-28', CarbonImmutable::parse('2023-08-28', 'JST')->startOfWeek(CarbonImmutable::MONDAY)],
        ];
    }

    public static function provideEndDateCases(): array
    {
        return [
            '終了日がnullの場合' => [null, CarbonImmutable::now('JST')->endOfWeek(CarbonImmutable::SUNDAY)],
            '終了日が指定された場合' => ['2023-09-03', CarbonImmutable::parse('2023-09-03', 'JST')->endOfWeek(CarbonImmutable::SUNDAY)],
        ];
    }

    public static function provideRulesCases(): array
    {
        return [
            '有効な開始日と終了日が指定された場合' => [['start' => '2023-08-28', 'end' => '2023-09-03'], true],
            '開始日が無効な日付の場合' => [['start' => 'invalid-date', 'end' => '2023-09-03'], false],
            '終了日が無効な日付の場合' => [['start' => '2023-08-28', 'end' => 'invalid-date'], false],
            '開始日と終了日が共にnullの場合' => [['start' => null, 'end' => null], true],
        ];
    }
}
