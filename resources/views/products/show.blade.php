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
    @php
        $averageRating = $product->average_rating;
        $averageRatingDisplay = abs($averageRating - round($averageRating)) < 0.001
            ? number_format($averageRating, 0, ',', ' ')
            : number_format($averageRating, 1, ',', ' ');
        $reviews = $product->approvedReviews()
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $hasOwnReview = auth()->check()
            ? \App\Models\Review::query()
                ->where('product_id', $product->id)
                ->where('user_id', auth()->id())
                ->where('status', '!=', \App\Models\Review::STATUS_REJECTED)
                ->exists()
            : false;
    @endphp

    <section class="section">
        <div class="container">
            <div class="reviews-section">
                <div class="reviews-header">
                    <div>
                        <h2>Отзывы о товаре</h2>
                        <p>Реальные впечатления покупателей после покупки. <a href="{{ route('reviews.index') }}">Все отзывы</a></p>
                    </div>
                    <div class="review-rating-summary">
                        <b>{{ $averageRatingDisplay }}/5</b>
                        <span>{{ $reviews->total() }} отзывов</span>
                    </div>
                </div>

                @auth
                    @if (! $hasOwnReview)
                        <form method="POST" action="{{ route('reviews.store', $product) }}" class="panel review-form">
                            @csrf
                            <div class="review-form-grid">
                                <label class="field">
                                    <span>Оценка</span>
                                    <select name="rating" required>
                                        @foreach (range(5, 1) as $r)
                                            <option value="{{ $r }}">{{ $r }} ★</option>
                                        @endforeach
                                    </select>
                                </label>

                                <label class="field">
                                    <span>Ваш отзыв</span>
                                    <textarea name="content" rows="4" required minlength="10" maxlength="2000"></textarea>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-orange">Отправить отзыв</button>
                        </form>
                    @else
                        <div class="panel review-note">
                            Вы уже оставляли отзыв на этот товар.
                        </div>
                    @endif
                @else
                    <div class="panel review-note">
                        <a href="{{ route('login') }}">Войдите</a>, чтобы оставить отзыв.
                    </div>
                @endauth

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
                            </div>
                        </article>
                    @empty
                        <article class="panel empty-state">
                            Пока нет отзывов. Будьте первым.
                        </article>
                    @endforelse
                </div>

                @if ($reviews->hasPages())
                    <div class="pager">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
