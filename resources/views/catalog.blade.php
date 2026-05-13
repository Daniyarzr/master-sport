@extends('layouts.app')

@section('title', 'Master Sport | Каталог')
@section('description', 'Каталог Master Sport: футболки, шорты, худи и коллекции.')

@section('content')
    <section class="section">
        <div class="container catalog-layout">
            <aside class="panel filter-panel">
                <h2>Фильтры</h2>
                <form method="GET" action="{{ route('catalog') }}" class="filter-form">
                    <label class="field">
                        <span>Поиск</span>
                        <input
                            type="text"
                            name="search"
                            value="{{ $filters['search'] }}"
                            placeholder="Например: худи, футболка..."
                        >
                    </label>

                    <label class="field">
                        <span>Категория</span>
                        <select name="category">
                            <option value="">Все категории</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) $category->id === $filters['category'])>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="field">
                        <span>Коллекция</span>
                        <select name="collection">
                            <option value="">Все коллекции</option>
                            @foreach ($collections as $collection)
                                <option value="{{ $collection->id }}" @selected((string) $collection->id === $filters['collection'])>
                                    {{ $collection->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <div class="filter-actions">
                        <button class="btn btn-orange" type="submit">Применить</button>
                        <a class="btn btn-light" href="{{ route('catalog') }}">Сбросить</a>
                    </div>
                </form>
            </aside>

            <div class="catalog-content">
                <div class="section-head">
                    <h2>Каталог товаров</h2>
                    <span>Показано: {{ $products->count() }}</span>
                </div>

                @if ($products->isEmpty())
                    <div class="panel empty-state">
                        По текущим фильтрам товаров не найдено.
                    </div>
                @else
                    <div class="product-grid">
                        @foreach ($products as $product)
                            <article class="panel product-card">
                                <div class="product-media">
                                    <img
                                        src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/master-sport-banner.png') }}"
                                        alt="{{ $product->name }}"
                                    >
                                </div>
                                <div class="product-card-body">
                                    <div class="product-card-top">
                                        <strong>{{ $product->name }}</strong>
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
                        @endforeach
                    </div>

                    <div class="pager">
                        @if ($products->previousPageUrl())
                            <a class="btn btn-light" href="{{ $products->previousPageUrl() }}">Назад</a>
                        @endif
                        @if ($products->nextPageUrl())
                            <a class="btn btn-light" href="{{ $products->nextPageUrl() }}">Дальше</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
