@extends('layouts.app')

@section('title', 'カレンダー編集')

@section('content')
<main class="container">
    <section>
        <h2 style="display: none;">カレンダー編集フォーム</h2>
        <form action="{{ route('calendars.update', ['uuid' => $calendar->url]) }}" method="POST">
            @method('PUT')
            @csrf
            <fieldset>
                <div class="form-group">
                    <label for="team-name">チーム</label>
                    <input type="text" id="team-name" name="team_name" placeholder="エンジニアチーム" value="{{ $calendar->team_name }}" required>
                </div>
                <div class="form-group">
                    <label for="memo">メモ</label>
                    <textarea id="memo" name="memo" placeholder="エンジニアチームのニコニコカレンダーです。毎日忘れないで入力しましょう！">{{ $calendar->memo }}</textarea>
                </div>
                <div class="form-group">
                    <label for="members">メンバー</label>
                    <textarea id="members" name="members" placeholder="鈴木&#10;佐藤&#10;山田" required>{{ $calendar->getMemberNames() }}</textarea>
                </div>
            </fieldset>
            <button type="submit">カレンダーを更新する</button>
            <p class='delete-link js-delete' data-uuid="{{ $calendar->url }}">カレンダーを削除する</p>
        </form>
    </section>
</main>
@endsection

@vite(['resources/css/calendar/edit.css'])
@vite(['resources/js/calendar/edit.js'])