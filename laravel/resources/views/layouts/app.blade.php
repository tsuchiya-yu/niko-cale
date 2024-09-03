<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- タイトル -->
    @hasSection('title')
        <title>@yield('title') | ニコカレ</title>
    @else
        <title>ニコカレ | 誰でも簡単にニコニコカレンダーが作れるツール</title>
    @endif
    <!-- robots -->
    @if (View::hasSection('index') && trim(View::getSection('index')) === 'true')
        <meta name="robots" content="index, follow">
    @else
        <meta name="robots" content="noindex, nofollow">
    @endif
    <!-- description -->
    @hasSection('description')
        <meta name="description" content="@yield('description')">
    @else
        <meta name="description" content="ニコカレは、チームのモチベーション管理ツール「ニコニコカレンダー」が誰でも簡単に作成できるツールです。">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/reset.css'])
    @yield('head')
</head>
<body>
    <x-header/>
    <div id="content">
        @yield('content')
    </div>
    <x-footer/>
</body>
<script>
    // ヘッダーの高さ分だけコンテンツを下にずらす
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.header');
        const content = document.getElementById('content');
        content.style.marginTop = `${header.offsetHeight}px`;
    });
    window.addEventListener('resize', function() {
        const header = document.querySelector('.header');
        const content = document.getElementById('content');
        content.style.marginTop = `${header.offsetHeight}px`;
    });
</script>
</html>
