@extends('layouts.app')

@section('title', 'Master Sport | Акции')
@section('description', 'Текущие акции и специальные предложения от Master Sport.')

@section('content')
    <section class="section stocks-hero">
        <div class="container">
            <div class="stocks-hero-inner panel">
                <div>
                    <span class="eyebrow">Акции Master Sport</span>
                    <h1>Специальные предложения</h1>
                    <p>Скидки на коллекции, сезонные распродажи и бонусы для постоянных покупателей.</p>
                </div>
                <a class="btn btn-orange" href="{{ route('catalog') }}">Перейти в каталог</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($stocks->isEmpty())
                <article class="panel stocks-empty">
                    <i class="bi bi-megaphone" aria-hidden="true"></i>
                    <h2>Пока нет акций</h2>
                    <p>Следите за обновлениями — скоро появятся новые предложения!</p>
                    <a class="btn btn-light" href="{{ route('catalog') }}">Смотреть товары</a>
                </article>
            @else
                <div class="stocks-grid">
                    @foreach ($stocks as $stock)
                        <article class="panel stock-card">
                            @include('partials.stock-media', [
                                'stock' => $stock,
                                'badge' => $stock->isActive()
                                    ? '<span class="stock-badge stock-badge-active">Активна</span>'
                                    : '<span class="stock-badge stock-badge-ended">Завершена</span>',
                            ])
                            <div class="stock-card-body">
                                <h2>
                                    <a href="{{ route('stocks.show', $stock) }}">{{ $stock->title }}</a>
                                </h2>
                                <p>{{ Str::limit(strip_tags($stock->description), 140) }}</p>
                                <div class="stock-meta">
                                    <span>
                                        <i class="bi bi-calendar3" aria-hidden="true"></i>
                                        {{ $stock->start_date?->format('d.m.Y') }} — {{ $stock->end_date?->format('d.m.Y') }}
                                    </span>
                                </div>
                                <a class="stock-read-more" href="{{ route('stocks.show', $stock) }}">
                                    Подробнее
                                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
