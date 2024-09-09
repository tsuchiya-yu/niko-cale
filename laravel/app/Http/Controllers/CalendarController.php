<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calendar\ShowRequest;
use App\Http\Requests\Calendar\StoreRequest;
use App\Http\Requests\Calendar\UpdateRequest;
use App\Models\Calendar;
use App\Models\CalendarMember;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function create()
    {
        return view('calendars.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Calendar::class);

        $calendar = DB::transaction(function () use ($request) {
            $calendar = $request->makeCalendar();
            $calendar->save();

            foreach ($request->membersArray() as $memberData) {
                $member = new CalendarMember($memberData);
                $member->calendar()->associate($calendar);
                $member->save();
            }

            return $calendar;
        });

        return redirect()->route('calendars.stored', ['uuid' => $calendar->url]);
    }

    public function stored(string $uuid)
    {
        $calendar = Calendar::where('url', $uuid)->firstOrFail();

        return view('calendars.stored', ['calendar' => $calendar]);
    }

    public function show(ShowRequest $request, string $uuid)
    {
        $calendar = Calendar::where('url', $uuid)->with(['members.conditions'])->firstOrFail();

        $start = $request->startDate();
        $end = $request->endDate();

        return view(
            'calendars.show',
            [
                'calendar' => $calendar,
                'start' => $start,
                'end' => $end,
            ]
        );
    }

    public function edit(string $uuid)
    {
        $calendar = Calendar::where('url', $uuid)->with(['members.conditions'])->firstOrFail();

        return view('calendars.edit', ['calendar' => $calendar]);
    }

    public function update(UpdateRequest $request, string $uuid)
    {
        \Log::info('update');
        $calendar = Calendar::where('url', $uuid)->firstOrFail();

        DB::transaction(function () use ($request, $calendar) {
            // カレンダー更新
            $calendar->update($request->validated());

            // メンバー更新
            // 既存のメンバー名を取得
            $existingMemberNames = $calendar->members->pluck('name')->toArray();
            // リクエストから新しいメンバー名を取得
            $newMemberNames = array_column($request->membersArray(), 'name');
            // 削除すべきメンバー
            $membersToDelete = array_diff($existingMemberNames, $newMemberNames);
            // 追加すべきメンバー
            $membersToAdd = array_diff($newMemberNames, $existingMemberNames);
            // メンバーの削除
            if (! empty($membersToDelete)) {
                $calendar->members()->whereIn('name', $membersToDelete)->delete();
            }
            // メンバーの追加
            foreach ($membersToAdd as $name) {
                $calendar->members()->create(['name' => $name]);
            }
        });

        $start = CarbonImmutable::parse($request->query('start', 'now'))->startOfWeek(CarbonImmutable::MONDAY);
        $end = CarbonImmutable::parse($request->query('end', 'now'))->endOfWeek(CarbonImmutable::SUNDAY);

        return view(
            'calendars.show',
            [
                'calendar' => $calendar->refresh(),
                'start' => $start,
                'end' => $end,
            ]
        );
    }
}
