<header class="header">
    <a href="{{ route('top') }}">
        <div class="wrap-logo">
            <img src="{{ asset('images/service_logo.png') }}" class="logo">
            <div class="title">ニコカレ</div>
        </div>
    </a>
    <div class="menu-icon" id="menu-icon">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>

<div class="overlay" id="overlay">
    <div class="close-icon" id="close-icon">
        <span></span>
        <span></span>
    </div>
    <div class='link-box'>
        <a href="{{ route('calendars.create') }}">
            <p>カレンダーをつくる</p>
        </a>
        <a href="{{ route('top') }}">
            <p>ニコカレについて</p>
        </a>
    </div>
</div>

<style>
.header {
    background-color: #fecd2f;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

.wrap-logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.header .logo {
    width: 40px;
}

.title {
    font-size: 1.5em;
    font-weight: bold;
    color: #fff;
}

.menu-icon {
    width: 30px;
    height: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
    z-index: 1002;
}

.menu-icon span, .close-icon span {
    display: block;
    height: 3px;
    background-color: #fff;
    border-radius: 3px;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.menu-icon.active span:nth-child(1) {
    transform: translateY(8px) rotate(45deg);
}

.menu-icon.active span:nth-child(2) {
    opacity: 0;
}

.menu-icon.active span:nth-child(3) {
    transform: translateY(-8px) rotate(-45deg);
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #fecd2f;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    font-size: 2em;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    z-index: 1001;
}

.overlay.active {
    opacity: 1;
    visibility: visible;
}

.close-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    z-index: 1003;
}

.close-icon span:nth-child(1) {
    transform: rotate(45deg);
    position: absolute;
    width: 100%;
}

.close-icon span:nth-child(2) {
    transform: rotate(-45deg);
    position: absolute;
    width: 100%;
}

.link-box {
    text-align: center;
    margin-top: 100px;
    font-size: 24px;
    line-height: 2;
}
</style>

<script>
    document.getElementById('menu-icon').addEventListener('click', function() {
        this.classList.toggle('active');
        document.getElementById('overlay').classList.toggle('active');
    });

    document.getElementById('close-icon').addEventListener('click', function() {
        document.getElementById('menu-icon').classList.remove('active');
        document.getElementById('overlay').classList.remove('active');
    });
</script>
