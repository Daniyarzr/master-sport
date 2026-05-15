@php
    $cartCount = auth()->check()
        ? \App\Models\CartItem::query()->where('user_id', auth()->id())->sum('quantity')
        : 0;
@endphp

<div class="site-topline">
    <div class="container site-topline-inner">
        <span>Master Sport · Ижевск</span>
        <span>Ежедневно 09:00-21:00 · +7 (3412) 90-00-00</span>
    </div>
</div>

<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark" aria-hidden="true"><img src="/storage/logo.png" alt="logo"></span>
            <span class="brand-text">Master Sport</span>
        </a>

        <nav class="main-nav" aria-label="Главное меню">
            <a class="{{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ route('home') }}">Главная</a>
            <a class="{{ request()->routeIs('catalog') ? 'is-active' : '' }}" href="{{ route('catalog') }}">Каталог</a>
            <a class="{{ request()->routeIs('contacts') ? 'is-active' : '' }}" href="{{ route('contacts') }}">Контакты</a>
        </nav>

        <div class="action-group">
            @auth
                <a
                    class="icon-btn {{ request()->routeIs('cart.*') ? 'is-active' : '' }}"
                    href="{{ route('cart.index') }}"
                    aria-label="Корзина"
                    title="Корзина"
                >
                    <i class="bi bi-cart3" aria-hidden="true"></i>
                    @if ($cartCount > 0)
                        <span class="icon-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                <a
                    class="icon-btn {{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
                    href="{{ route('dashboard') }}"
                    aria-label="Личный кабинет"
                    title="Личный кабинет"
                >
                    <i class="bi bi-person-circle" aria-hidden="true"></i>
                </a>

                @if (auth()->user()->isAdmin())
                    <a
                        class="icon-btn {{ request()->routeIs('admin.*') ? 'is-active' : '' }}"
                        href="{{ route('admin.dashboard') }}"
                        aria-label="Админ"
                        title="Админ"
                    >
                        <i class="bi bi-shield-lock" aria-hidden="true"></i>
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="icon-btn icon-btn-logout" type="submit" aria-label="Выход" title="Выход">
                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>
            @else
                <a class="btn btn-light" href="{{ route('login') }}">Вход</a>
                <a class="btn btn-dark" href="{{ route('register') }}">Регистрация</a>
            @endauth
        </div>
    </div>
</header>
