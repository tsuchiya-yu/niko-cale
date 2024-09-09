@extends('layouts.app')

@section('title', 'カレンダー作成')
@section('index', 'true')

@section('content')
<main class="container">
    <aside>
        <h1 style="display: none;">ニコカレ</h1>
        <p>ニコカレはURLをメンバーに送るだけで、簡単にニコニコカレンダーがつくれるツールです。</p>
    </aside>
    <section>
        <h2 style="display: none;">カレンダー作成フォーム</h2>
        <form action="{{ route('calendars.store') }}" method="POST">
            @csrf
            <fieldset>
                <div class="form-group">
                    <label for="team-name">チーム</label>
                    <input type="text" id="team-name" name="team_name" placeholder="エンジニアチーム" required>
                </div>
                <div class="form-group">
                    <div class="label-box">
                        <label for="memo">メモ</label>
                        <div class="optional-badge">任意</div>
                    </div>
                    <textarea id="memo" name="memo" placeholder="エンジニアチームのニコニコカレンダーです。毎日忘れないで入力しましょう！"></textarea>
                </div>
                <div class="form-group">
                    <label for="members">メンバー</label>
                    <textarea id="members" name="members" placeholder="鈴木&#10;佐藤&#10;山田" required></textarea>
                </div>
            </fieldset>
            <div class="term"><a href="{{ route('terms') }}" target="_blank" class='link'>利用規約</a>・<a href="{{ route('privacy') }}" target="_blank" class='link'>プライバシーポリシー</a>に同意のうえ</div>
            <button type="submit">カレンダーをつくる</button>
        </form>
    </section>
</main>
@endsection

@vite(['resources/css/calendar/create.css'])
