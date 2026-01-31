<div class="header__search">
    <form id="search-form" action="{{ route('home') }}" method="GET">
        <input type="search" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}" />
    </form>
    <input type="hidden" name="tab" value="{{ request('tab', '') }}">
</div>
<div class="header__auth">
    @auth
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="header__link">ログアウト</button>
        </form>
    @else
        <a href="/login" class="header__link">ログイン</a>
    @endauth
    <div class="header__mypage">
        <a href="/mypage" class="header__link">マイページ</a>
    </div>
    <div class="header__sell">
        <a href="/sell" class="header__btn">出品</a>
    </div>
</div>