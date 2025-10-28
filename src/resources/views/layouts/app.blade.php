<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'hurima')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    @stack('styles')
</head>


<body>
    <header class="site-header">

        <div class="site.logo">
            <img src="{{ asset('images/logo.svg') }}" alt="会社ロゴ">
        </div>

        <form action="{{ route('items.search') }}" method="GET" class="site-search">
            <input
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="なにをお探しですか？"
                aria-label="サイト内検索">
            <button type="submit">検索</button>
        </form>
        <div class="header-right">
            {{-- 非ログイン時 --}}
            @guest
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('mypage.index') }}">マイページ</a>
            <a href="{{ route('items.sell') }}" class="btn">出品</a>
            @endguest

            {{-- ログイン時 --}}
            @auth
            <div class="logout-actions">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
            </div>
            <div class="mypage">
                <a href="{{ route('mypage.index') }}">マイページ</a>
                <a href="{{ route('items.sell') }}" class="btn">出品</a>
            </div>
            @endauth
        </div>
    </header>
    </header>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <main>
        @yield('content')
    </main>
</body>