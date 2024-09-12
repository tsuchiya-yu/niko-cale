@extends('layouts.app')

@section('title', 'カレンダー作成完了')

@section('content')
    <main class="container">
        <aside>
            <h1>{{ $calendar->team_name }}のカレンダーができました！</h1>
        </aside>
        <section>
            <p>以下のURLをメンバーに知らせましょう。このURLから各メンバーにその日の気持ちを入力してもらえます。</p>
            <div class="form-group">
                <input type="text" id="url" name="url" class='url js-copy'
                    value={{ route('calendars.show', ['uuid' => $calendar->url]) }} readonly>
            </div>
            <p class='link js-copy'>URLをコピーする</p>
            <a href="{{ route('calendars.show', ['uuid' => $calendar->url]) }}">
                <button>カレンダーを開く</button>
            </a>
        </section>
    </main>

    <script>
        document.querySelectorAll('.js-copy').forEach(element => {
            element.addEventListener('click', function() {
                const urlInput = document.querySelector('input[name="url"]');
                // クリップボードにコピー
                urlInput.select();
                urlInput.setSelectionRange(0, 99999);
                document.execCommand('copy');
                alert('URLをコピーしました！');
            });
        });
    </script>
@endsection

@vite(['resources/css/calendar/stored.css'])
