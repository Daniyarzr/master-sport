<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Админ-панель') | Master Sport</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Unbounded:wght@500;700&display=swap"
            rel="stylesheet"
        >
        <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    </head>
    <body>
        <div class="top-ribbon">
            Панель управления Master Sport · только для администраторов
        </div>

        <header class="site-header">
            <div class="container">
                <div class="nav-shell">
                    <a class="brand" href="{{ route('home') }}">
                        <span class="brand-mark" aria-hidden="true"></span>
                        <span class="brand-text">MASTER SPORT</span>
                    </a>

                    <nav class="nav-links" aria-label="Админ-меню">
                        <a href="{{ route('home') }}">Сайт</a>
                        <a class="is-active is-admin-link" href="{{ route('admin.dashboard') }}">Админка</a>
                        <a href="{{ route('catalog') }}">Каталог</a>
                    </nav>

                    <div class="nav-actions">
                        <span class="btn btn-outline" style="pointer-events: none;">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn btn-primary" type="submit">Выйти</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="admin-page">
            <div class="container">
                @if (session('status'))
                    <div class="admin-alert" role="status">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="admin-alert is-error" role="alert">
                        <ul style="margin: 0; padding-left: 1.1rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </body>
</html>
