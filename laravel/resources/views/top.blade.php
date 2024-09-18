@extends('layouts.app')

@section('title', 'トップページ')
@section('index', 'true')

@section('content')
<main class="container">
    <aside>
        <h1 style="display: none;">ニコカレとは</h1>
        <div class='grey-box'>
            <p>「ニコカレ」は<span style="background: linear-gradient(transparent 50%, #ff6 50%);">ニコニコカレンダーを簡単につくれるツール</span>です。あたなのチームでも使ってみましょう。</p>
        </div>
    </aside>
    <section>
        <h2>ニコニコカレンダーとは？</h2>
        <p>ニコニコカレンダーとは、日々の気分や士気(モチベーション)を記録し、見える化するツールです。カレンダー上に、その日の調子をつけることで、日々の変化を一目で把握できます。</p>
        <p>ソフトウエア開発をはじめとした様々な組織/チームで活用されています。</p>
    </section>
    <a href="{{ route('calendars.create') }}">
        <button type="submit">カレンダーをつくる</button>
    </a>
    <section>
        <h2>ニコカレの３つの特徴</h2>
        <p>・面倒なログインが一切なし</p>
        <p>・PCとスマホどちらでもOK！</p>
        <p>・全員の調子が一目でわかる！</p>
        <img src="{{ Vite::asset('images/calendar_capture.png') }}" class="calendar_capturep">
    </section>
    <a href="{{ route('calendars.create') }}">
        <button type="submit">カレンダーをつくる</button>
    </a>
</main>
@endsection

@vite(['resources/css/top.css'])
