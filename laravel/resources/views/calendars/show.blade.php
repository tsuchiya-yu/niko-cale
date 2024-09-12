@extends('layouts.app')

@section('title', 'カレンダー詳細')

@section('content')
    <main class="container">
        <aside>
            <h1>{{ $calendar->team_name }}のカレンダー</h1>
            <p>{!! nl2br(e($calendar->memo)) !!}</p>
        </aside>
        <section class="calendar-container">
            <table class="calendar">
                <thead>
                    <tr>
                        <th class='name-colmun'>日程</th>
                        @for ($date = $start; $date <= $end; $date = $date->addDay())
                            <th class="{{ $date->isToday() ? 'today' : '' }}">
                                {{ $date->format('n/j') }}<br>({{ ['日', '月', '火', '水', '木', '金', '土'][$date->dayOfWeek] }})
                            </th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($calendar->members as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            @for ($date = $start; $date <= $end; $date = $date->addDay())
                                @php
                                    $condition = $member->conditions->firstWhere('date', $date->format('Y-m-d'));
                                @endphp
                                <td class="cell" data-member-id="{{ $member->id }}"
                                    data-date="{{ $date->format('Y-m-d') }}" data-name="{{ $member->name }}">
                                    @if ($condition)
                                        <img src="{{ Vite::asset('resources/images/conditions/' . $condition->condition->value . '.png') }}">
                                    @else
                                        <p></p>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
        <section class="buttons">
            <a href="{{ route('calendars.show', [
                'uuid' => $calendar->url,
                'start' => $start->copy()->subDays(7)->format('Y-m-d'),
                'end' => $start->copy()->subDays(1)->format('Y-m-d'),
            ]) }}"
                class="link">
                前の週
            </a>
            <a href="{{ route('calendars.show', [
                'uuid' => $calendar->url,
            ]) }}"
                class="link">
                今週を表示
            </a>
            <a href="{{ route('calendars.show', [
                'uuid' => $calendar->url,
                'start' => $end->copy()->addDays(1)->format('Y-m-d'),
                'end' => $end->copy()->addDays(7)->format('Y-m-d'),
            ]) }}"
                class="link">
                次の週
            </a>
        </section>
        <section class="section edit-section">
            <a href="{{ route('calendars.edit', ['uuid' => $calendar->url]) }}">
                <button class="button-half">カレンダーを編集</button>
            </a>
        </section>
        <section class="section">
            <h2>ページを共有する</h2>
            <p>以下のURLをメンバーに共有しましょう。</p>
            <div class="form-group">
                <input type="text" id="url" name="url" class="url js-copy"
                    value="{{ route('calendars.show', ['uuid' => $calendar->url]) }}" readonly>
            </div>
            <p class="link copy js-copy">URLをコピーする</p>
        </section>

        <!-- モーダル -->
        <div id="conditionModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div style='display: none;'>
                    <p>Member ID: <span id="modalMemberId"></span></p>
                    <p>Date: <span id="modalDate"></span></p>
                </div>
                <h3><span id="modalName"></span>さん</h3>
                <p>今日の調子はいかがですか？</p>
                <div class="mood-selector">
                    @foreach (\App\Enums\ConditionStatus::cases() as $condition)
                        <div class='wrap-icon'>
                            <img src="{{ Vite::asset('resources/images/conditions/' . $condition->value . '.png') }}" 
                                class="mood-icon" 
                                data-mood="{{ $condition->value }}">
                        </div>
                    @endforeach
                </div>
                <div style='text-align: center;'>
                    <button class="button-half" id="edit-button">登録する</button>
                    <p id="reset-button" class='gray-text'>未選択にする</p>
                </div>
            </div>
        </div>
    </main>
@endsection

@vite(['resources/css/calendar/show.css'])
@vite(['resources/js/calendar/show.js'])