<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Вход | Master Sport</title>
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
            Вход в систему <strong>Master Sport</strong>
        </div>

        <main class="admin-page">
            <div class="container" style="max-width: 480px;">
                <section class="admin-hero">
                    <h1>Вход</h1>
                    <p>Администраторы попадают в панель управления после авторизации.</p>
                </section>

                @if ($errors->any())
                    <div class="admin-alert is-error" role="alert">
                        <ul style="margin: 0; padding-left: 1.1rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <article class="admin-card">
                    <form action="{{ route('login.store') }}" method="post">
                        @csrf
                        <div class="filter-group">
                            <label for="email">Email</label>
                            <input class="search-input" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="filter-group">
                            <label for="password">Пароль</label>
                            <input class="search-input" id="password" name="password" type="password" required>
                        </div>
                        <label class="admin-checkbox">
                            <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                            Запомнить меня
                        </label>
                        <button class="btn btn-accent" type="submit" style="margin-top: 0.85rem; width: 100%;">Войти</button>
                    </form>
                    <p style="margin: 1rem 0 0; text-align: center;">
                        <a href="{{ route('home') }}">← На главную</a>
                    </p>
                </article>
            </div>
        </main>
    </body>
</html>
