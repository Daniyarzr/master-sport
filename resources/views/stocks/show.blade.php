@extends('layouts.app')

@section('title', 'Master Sport | ' . $stock->title)
@section('description', Str::limit(strip_tags($stock->description), 160))

@section('content')
    <section class="section">
        <div class="container stock-show-wrap">
            <a class="article-back" href="{{ route('stocks.index') }}">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                Все акции
            </a>

            <article class="panel stock-show">
                <div class="stock-show-hero">
                    @if ($stock->image_path)
                        <img src="{{ asset($stock->image_path) }}" alt="{{ $stock->title }}">
                    @else
                        <span class="product-media-placeholder product-media-placeholder-lg">Нет фото</span>
                    @endif
                    @if ($stock->isActive())
                        <span class="stock-badge stock-badge-active">Акция действует</span>
                    @else
                        <span class="stock-badge stock-badge-ended">Акция завершена</span>
                    @endif
                </div>

                <div class="stock-show-body">
                    <span class="eyebrow">Специальное предложение</span>
                    <h1>{{ $stock->title }}</h1>
                    <div class="stock-meta stock-meta-lg">
                        <span>
                            <i class="bi bi-calendar3" aria-hidden="true"></i>
                            {{ $stock->start_date?->format('d.m.Y') }} — {{ $stock->end_date?->format('d.m.Y') }}
                        </span>
                    </div>
                    <div class="stock-show-content">
                        {!! nl2br(e($stock->description)) !!}
                    </div>
                    <div class="hero-actions">
                        <a class="btn btn-orange" href="{{ route('catalog') }}">Смотреть каталог</a>
                        <a class="btn btn-light" href="{{ route('stocks.index') }}">Другие акции</a>
                    </div>
                </div>
            </article>
        </div>
    </section>
@endsection
