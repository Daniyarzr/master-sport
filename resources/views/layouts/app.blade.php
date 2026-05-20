<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Master Sport')</title>
        <meta
            name="description"
            content="@yield('description', 'Master Sport - магазин спортивной одежды и базовой экипировки.')">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Unbounded:wght@500;700&display=swap"
            rel="stylesheet">
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
        @stack('styles')
        <link rel="icon" type="image/vnd.microsoft.icon" href="/storage/favicon.ico" />
    </head>
    <body>
        @include('partials.header')

        <main class="page-main">
            <div class="container">
                @if (session('status'))
                    <div class="flash flash-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="flash flash-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>

        @include('partials.footer')
    </body>
</html>
