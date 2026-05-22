@php
    $cartCount = auth()->check()
        ? \App\Models\CartItem::query()->where('user_id', auth()->id())->sum('quantity')
        : 0;
@endphp

<div class="site-topline">
    <div class="container site-topline-inner">
        <span>{{ $headerToplineLeft }}</span>
        @if ($headerToplineRight)
            <span>{{ $headerToplineRight }}</span>
        @endif
    </div>
</div>

<header class="site-header" data-header>
    <div class="container header-inner">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark" aria-hidden="true"><img src="/storage/logo.png" alt="logo"></span>
            <span class="brand-text">Master Sport</span>
        </a>

        <button
            class="menu-toggle"
            type="button"
            aria-expanded="false"
            aria-controls="header-menu"
            data-menu-toggle
        >
            <span class="menu-toggle-icon" aria-hidden="true"></span>
            <span>Меню</span>
        </button>

        <div class="header-menu" id="header-menu" data-menu>
            <nav class="main-nav" aria-label="Главное меню">
                <a class="{{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ route('home') }}">Главная</a>
                <a class="{{ request()->routeIs('catalog*') ? 'is-active' : '' }}" href="{{ route('catalog') }}">Каталог</a>
                <a class="{{ request()->routeIs('reviews.*') ? 'is-active' : '' }}" href="{{ route('reviews.index') }}">Отзывы</a>
                <a class="{{ request()->routeIs('stocks.*') ? 'is-active' : '' }}" href="{{ route('stocks.index') }}">Акции</a>
                <a class="{{ request()->routeIs('contacts') ? 'is-active' : '' }}" href="{{ route('contacts') }}">Контакты</a>
                <a class="{{ request()->routeIs('articles.*') ? 'is-active' : '' }}" href="{{ route('articles.index') }}">Статьи</a>
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
                            href="{{ route('admin.index') }}"
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
    </div>
</header>

<script>
    (() => {
        const header = document.querySelector('[data-header]');
        if (!header) return;

        const toggle = header.querySelector('[data-menu-toggle]');
        const menu = header.querySelector('[data-menu]');
        if (!toggle || !menu) return;

        const closeMenu = () => {
            header.classList.remove('is-menu-open');
            toggle.setAttribute('aria-expanded', 'false');
        };

        header.classList.add('has-menu-js');
        closeMenu();

        toggle.addEventListener('click', () => {
            const isOpen = header.classList.toggle('is-menu-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        menu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.matchMedia('(max-width: 760px)').matches) {
                    closeMenu();
                }
            });
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 760) {
                closeMenu();
            }
        });
    })();
</script>
