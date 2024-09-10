<footer class="footer">
    <a href="{{ route('calendars.create') }}">
        <p>カレンダーをつくる</p>
    </a>
    <a href="{{ route('top') }}">
        <p>ニコカレについて</p>
    </a>
    <a href="{{ route('privacy') }}">
        <p>プライバシーポリシー</p>
    </a>
    <a href="{{ route('terms') }}">
        <p>利用規約</p>
    </a>
    <a href="https://docs.google.com/forms/d/e/1FAIpQLSc1FnFHMNKbnkS0tbL-S-A50qY5-zLOJFr9d4E_BzXlyCGdWA/viewform">
        <p>お問い合わせ</p>
    </a>
</footer>

<style>
.footer {
    background-color: #f0f0f0;
    padding: 10px 0;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    position: sticky;
    top: 100vh;
    font-size: 16px;
}

.footer a {
    color: #333;
    text-decoration: none;
    margin: 0 10px;
    font-weight: bold;
    text-align: center;
    width: 45%;
}

@media (min-width: 600px) {
    .footer a {
        width: auto;
        margin-bottom: 0;
        margin: 0 5px;
    }
}
</style>
