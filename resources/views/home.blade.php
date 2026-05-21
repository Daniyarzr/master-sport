@extends('layouts.app')

@section('title', 'Master Sport | Главная')
@section('description', 'Master Sport: стильная спортивная одежда, коллекции и новинки.')

@section('content')
    <section class="section banner-section">
        <div class="container">
            <article class="hero-banner hero-banner-compact">
                <img
                    src="{{ asset('images/master-sport-banner.png') }}"
                    alt="Баннер Master Sport"
                    class="hero-banner-image"
                >
                <div class="hero-banner-overlay"></div>
                <div class="hero-banner-content">
                    <span class="eyebrow">Новая коллекция · 2026</span>
                    <h1>Твой ритм. Твой стиль. Твой Master Sport.</h1>
                    <p>Футболки, шорты и худи в фирменной палитре с оранжевыми акцентами.</p>
                    <div class="hero-actions">
                        <a class="btn btn-orange" href="{{ route('catalog') }}">Смотреть каталог</a>
                        @auth
                            <a class="btn btn-light" href="{{ route('cart.index') }}">Моя корзина</a>
                        @else
                            <a class="btn btn-light" href="{{ route('login') }}">Войти и покупать</a>
                        @endauth
                        <a class="btn btn-dark call-btn-desktop" href="{{ route('contacts') }}">
                            <i class="bi bi-telephone" aria-hidden="true"></i>
                            Позвонить
                        </a>
                        @if ($primaryPhoneContact)
                            <a class="btn btn-dark call-btn-mobile" href="{{ $primaryPhoneContact->resolved_href }}">
                                <i class="bi bi-telephone" aria-hidden="true"></i>
                                Позвонить
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        </div>
    </section>

    @if ($promoStocks->isNotEmpty())
        <section class="section">
            <div class="container">
                <div class="section-head">
                    <h2>Акции</h2>
                    <a href="{{ route('stocks.index') }}">Все акции</a>
                </div>

                <div class="stocks-grid stocks-grid-home">
                    @foreach ($promoStocks as $stock)
                        <article class="panel stock-card">
                            @include('partials.stock-media', [
                                'stock' => $stock,
                                'badge' => '<span class="stock-badge stock-badge-active">Акция</span>',
                            ])
                            <div class="stock-card-body">
                                <h3>
                                    <a href="{{ route('stocks.show', $stock) }}">{{ $stock->title }}</a>
                                </h3>
                                <p>{{ Str::limit(strip_tags($stock->description), 100) }}</p>
                                <a class="stock-read-more" href="{{ route('stocks.show', $stock) }}">
                                    Подробнее
                                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Почему выбирают нас</h2>
                <a href="{{ route('catalog') }}">Перейти к товарам</a>
            </div>

            <div class="story-grid">
                <article class="panel story-card">
                    <h3>Технологичные ткани</h3>
                    <p>Материалы, которые дышат и держат форму после активных тренировок и частой стирки.</p>
                </article>
                <article class="panel story-card">
                    <h3>Идеальная посадка</h3>
                    <p>Модели рассчитаны под движение: удобно в зале, на улице и в ежедневном ритме.</p>
                </article>
                <article class="panel story-card">
                    <h3>Честные остатки</h3>
                    <p>Остатки по складу и заказы в личном кабинете обновляются в реальном времени.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Новинки</h2>
                <a href="{{ route('catalog') }}">Открыть весь каталог</a>
            </div>

            <div class="product-grid product-grid-home">
                @forelse ($featuredProducts as $product)
                    <article class="panel product-card">
                        @include('partials.product-media', ['product' => $product])
                        <div class="product-card-body">
                            <div class="product-card-top">
                                <strong>
                                    <a href="{{ route('catalog.show', $product) }}">{{ $product->name }}</a>
                                </strong>
                            </div>
                            <p>{{ $product->description ?: 'Описание скоро добавим.' }}</p>
                            <div class="meta-row">
                                <span>{{ $product->category?->name ?? 'Без категории' }}</span>
                                <span>{{ $product->collection?->name ?? 'Без коллекции' }}</span>
                                <span>Остаток: {{ $product->stock }}</span>
                            </div>

                            @auth
                                <div class="product-buy-row">
                                    <b class="product-price-inline">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</b>
                                    <form method="POST" action="{{ route('cart.add', $product) }}" class="cart-inline-form">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button class="btn btn-orange cart-add-btn" type="submit" @disabled($product->stock < 1)>
                                            <i class="bi bi-plus-lg" aria-hidden="true"></i>
                                            <span>{{ $product->stock < 1 ? 'Нет в наличии' : 'В корзину' }}</span>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="product-buy-row">
                                    <b class="product-price-inline">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</b>
                                    <a class="btn btn-light cart-inline-link" href="{{ route('login') }}">Войти для покупки</a>
                                </div>
                            @endauth
                        </div>
                    </article>
                @empty
                    <article class="panel empty-state">
                        Товаров пока нет. Запусти сидер, чтобы загрузить демонстрационные позиции.
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Коллекции</h2>
                <a href="{{ route('catalog') }}">Смотреть товары</a>
            </div>

            <div class="collection-grid">
                @forelse ($collections as $collection)
                    <article class="panel collection-card">
                        <h3>{{ $collection->name }}</h3>
                        <p>{{ $collection->description ?: 'Коллекция без описания.' }}</p>
                        <span>{{ $collection->products_count }} товаров</span>
                    </article>
                @empty
                    <article class="panel collection-card">
                        <h3>Коллекций пока нет</h3>
                        <p>Добавь данные через сидер, чтобы заполнить витрину.</p>
                        <span>0 товаров</span>
                    </article>
                @endforelse
            </div>
        </div>
    </section>
@endsection
