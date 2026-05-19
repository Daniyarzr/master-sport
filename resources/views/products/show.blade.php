@extends('layouts.app')

@section('title', 'Master Sport | ' . $product->name)
@section('description', Str::limit($product->description ?: $product->name, 160))

@section('content')
    <section class="section">
        <div class="container">
            <a class="article-back" href="{{ route('catalog') }}">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                Назад в каталог
            </a>

            <div class="product-show-layout">
                <article class="panel product-show-gallery">
                    @include('partials.product-gallery', ['product' => $product])
                </article>

                <article class="panel product-show-info">
                    <div class="meta-row">
                        <span>{{ $product->category?->name ?? 'Без категории' }}</span>
                        <span>{{ $product->collection?->name ?? 'Без коллекции' }}</span>
                    </div>

                    <h1>{{ $product->name }}</h1>
                    <p class="product-show-price">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</p>

                    <p class="product-show-desc">{{ $product->description ?: 'Описание скоро добавим.' }}</p>

                    <ul class="product-specs">
                        @if ($product->brand)
                            <li><span>Бренд</span><b>{{ $product->brand }}</b></li>
                        @endif
                        @if ($product->size)
                            <li><span>Размеры</span><b>{{ $product->size }}</b></li>
                        @endif
                        @if ($product->color)
                            <li><span>Цвет</span><b>{{ $product->color }}</b></li>
                        @endif
                        @if ($product->gender)
                            <li><span>Пол</span><b>{{ $product->gender }}</b></li>
                        @endif
                        <li><span>В наличии</span><b>{{ $product->stock }} шт.</b></li>
                    </ul>

                    @auth
                        <form method="POST" action="{{ route('cart.add', $product) }}" class="product-show-buy">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button class="btn btn-orange" type="submit" @disabled($product->stock < 1)>
                                <i class="bi bi-cart-plus" aria-hidden="true"></i>
                                {{ $product->stock < 1 ? 'Нет в наличии' : 'Добавить в корзину' }}
                            </button>
                        </form>
                    @else
                        <div class="hero-actions">
                            <a class="btn btn-orange" href="{{ route('login') }}">Войти для покупки</a>
                            <a class="btn btn-light" href="{{ route('register') }}">Регистрация</a>
                        </div>
                    @endauth
                </article>
            </div>
        </div>
    </section>
@endsection
