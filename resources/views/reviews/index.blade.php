@extends('layouts.app')

@section('title', 'Master Sport | Отзывы')
@section('description', 'Отзывы покупателей Master Sport о товарах и качестве сервиса.')

@section('content')
    @php
        $averageRating = (float) ($reviewsStats['average'] ?? 0);
        $averageRatingDisplay = abs($averageRating - round($averageRating)) < 0.001
            ? number_format($averageRating, 0, ',', ' ')
            : number_format($averageRating, 1, ',', ' ');
    @endphp

    <section class="section">
        <div class="container">
            <div class="section-head">
                <h1>Отзывы покупателей</h1>
                <span>Опубликовано: {{ $reviewsStats['total'] }}</span>
            </div>

            <article class="panel reviews-overview">
                <div class="reviews-overview-item">
                    <span>Средняя оценка</span>
                    <strong>{{ $averageRatingDisplay }}/5</strong>
                </div>
                <div class="reviews-overview-item">
                    <span>Оценок 5★</span>
                    <strong>{{ $reviewsStats['fiveStars'] }}</strong>
                </div>
                <div class="reviews-overview-item">
                    <span>Всего отзывов</span>
                    <strong>{{ $reviewsStats['total'] }}</strong>
                </div>
            </article>

            <form method="GET" action="{{ route('reviews.index') }}" class="filter-actions reviews-filter-form">
                <label class="field">
                    <span>Фильтр по оценке</span>
                    <select name="rating">
                        <option value="">Все оценки</option>
                        @foreach (range(5, 1) as $rating)
                            <option value="{{ $rating }}" @selected($selectedRating === $rating)>{{ $rating }} ★</option>
                        @endforeach
                    </select>
                </label>
                <button class="btn btn-orange" type="submit">Показать</button>
                <a class="btn btn-light" href="{{ route('reviews.index') }}">Сбросить</a>
            </form>

            <div class="reviews-list-grid">
                @forelse ($reviews as $review)
                    <article class="panel review-card">
                        <div class="review-card-head">
                            <div class="review-stars" aria-label="Оценка {{ $review->rating }} из 5">
                                @for ($star = 1; $star <= 5; $star++)
                                    <span class="{{ $star <= $review->rating ? 'is-filled' : '' }}">★</span>
                                @endfor
                            </div>
                            <time datetime="{{ $review->created_at?->toDateString() }}">{{ $review->created_at?->format('d.m.Y') }}</time>
                        </div>

                        <p class="review-card-text">{{ $review->content }}</p>

                        <div class="review-card-meta">
                            <strong>{{ $review->getAuthorName() }}</strong>
                            @if ($review->product)
                                <a href="{{ route('catalog.show', $review->product->slug) }}">
                                    {{ Str::limit($review->product->name, 42) }}
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <article class="panel empty-state">
                        Отзывов пока нет.
                    </article>
                @endforelse
            </div>

            @if ($reviews->hasPages())
                <div class="pager">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
