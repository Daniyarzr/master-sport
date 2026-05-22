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
        $averageRating = $product->average_rating; // используем аксессор из модели
        $reviews = $product->approvedReviews()
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    @endphp

<div class="reviews-section mt-8">
    <h3 class="text-2xl font-bold mb-4">Отзывы ({{ $reviews->total() }})</h3>
    
    @if($averageRating > 0)
        <div class="mb-4 flex items-center gap-2">
            <span class="text-yellow-500">★</span>
            <span class="font-semibold">{{ number_format($averageRating, 1) }}/5</span>
        </div>
    @endif

    {{-- Форма отзыва --}}
    @auth
        @if(!\App\Models\Review::where('product_id', $product->id)->where('user_id', Auth::id())->where('status', '!=', 'rejected')->exists())
            <form method="POST" action="{{ route('reviews.store', $product) }}" class="mb-6 p-4 border rounded">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium">Оценка</label>
                    <select name="rating" class="border rounded p-2" required>
                        @foreach(range(5,1) as $r)
                            <option value="{{ $r }}">{{ $r }} ★</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Ваш отзыв</label>
                    <textarea name="content" class="border rounded p-2 w-full" rows="4" required minlength="10" maxlength="2000"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Отправить</button>
            </form>
        @else
            <p class="text-gray-500 mb-4">Вы уже оставляли отзыв на этот товар.</p>
        @endif
    @else
        <p class="mb-4"><a href="{{ route('login') }}" class="text-blue-600">Войдите</a>, чтобы оставить отзыв.</p>
    @endauth

    {{-- Список отзывов --}}
    @forelse($reviews as $review)
        <div class="border-b py-4">
            <div class="flex justify-between items-start">
                <div>
                    <strong>{{ $review->getAuthorName() }}</strong>
                    <span class="text-yellow-500 ml-2">{{ str_repeat('★', $review->rating) }}</span>
                </div>
                <small class="text-gray-500">{{ $review->created_at->format('d.m.Y') }}</small>
            </div>
            <p class="mt-2">{{ $review->content }}</p>
        </div>
    @empty
        <p class="text-gray-500">Пока нет отзывов. Будьте первым!</p>
    @endforelse

    {{ $reviews->links() }}
</div>
@endsection
