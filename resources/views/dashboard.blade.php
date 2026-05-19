@extends('layouts.app')

@section('title', 'Master Sport | Личный кабинет')
@section('description', 'Личный кабинет: профиль и заказы.')

@section('content')
    <section class="section">
        <div class="container dashboard-grid">
            <article class="panel profile-panel">
                @php
                    $avatarLetter = mb_strtoupper(mb_substr($user->name, 0, 1));
                @endphp

                <div class="profile-head">
                    <div class="profile-avatar">{{ $avatarLetter }}</div>
                    <div>
                        <h1>Личный кабинет</h1>
                        <p>Редактируй личные данные и пароль.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('dashboard.profile.update') }}" class="profile-form">
                    @csrf
                    @method('PUT')

                    <label class="field">
                        <span>Имя</span>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    </label>

                    <label class="field">
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </label>

                    <label class="field">
                        <span>Телефон</span>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    </label>

                    <label class="field">
                        <span>Адрес доставки</span>
                        <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Город, улица, дом, квартира">
                        <small class="field-hint">Подставляется при оформлении заказа с доставкой</small>
                    </label>

                    <label class="field">
                        <span>Новый пароль</span>
                        <input type="password" name="password" autocomplete="new-password">
                    </label>

                    <label class="field">
                        <span>Подтверждение пароля</span>
                        <input type="password" name="password_confirmation" autocomplete="new-password">
                    </label>

                    <button class="btn btn-orange" type="submit">Сохранить данные</button>
                </form>
            </article>

            <article class="panel summary-panel">
                <h2>Кратко</h2>
                <div class="stats-grid">
                    <div><span>Активные заказы</span><b>{{ $activeOrdersCount }}</b></div>
                    <div><span>Завершенные</span><b>{{ $completedOrdersCount }}</b></div>
                    <div><span>Товаров в магазине</span><b>{{ $productsCount }}</b></div>
                </div>

                <div class="hero-actions">
                    <a class="btn btn-light" href="{{ route('catalog') }}">Каталог</a>
                    <a class="btn btn-orange" href="{{ route('cart.index') }}">Корзина</a>
                    @if ($user->isAdmin())
                        <a class="btn btn-light" href="{{ route('admin.index') }}">Админ</a>
                    @endif
                </div>
            </article>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <article class="panel my-articles-panel">
                <div class="section-head">
                    <h2>Мои статьи</h2>
                    <a href="{{ route('articles.create') }}">Написать новую</a>
                </div>

                @if ($myArticles->isEmpty())
                    <p class="my-articles-empty">Вы ещё не публиковали статьи.</p>
                    <a class="btn btn-light" href="{{ route('articles.create') }}">Создать первую статью</a>
                @else
                    <div class="my-articles-list">
                        @foreach ($myArticles as $article)
                            <article class="my-article-row">
                                <div class="my-article-main">
                                    <span class="article-category">{{ $article->category }}</span>
                                    <h3>
                                        <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                                    </h3>
                                    <p>{{ Str::limit(strip_tags($article->content), 120) }}</p>
                                    <span class="my-article-date">{{ $article->created_at?->format('d.m.Y H:i') }}</span>
                                </div>
                                <form
                                    method="POST"
                                    action="{{ route('dashboard.articles.destroy', $article) }}"
                                    onsubmit="return confirm('Удалить эту статью?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-danger-outline">
                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                        Удалить
                                    </button>
                                </form>
                            </article>
                        @endforeach
                    </div>
                @endif
            </article>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <article class="panel orders-panel">
                <div class="section-head">
                    <h2>Мои заказы</h2>
                    <span>Всего: {{ $orders->count() }}</span>
                </div>

                @if ($errors->has('order'))
                    <p class="order-error">{{ $errors->first('order') }}</p>
                @endif

                @if ($orders->isEmpty())
                    <p>Заказов пока нет.</p>
                @else
                    @php
                        $statusLabels = [
                            'new' => 'Новый',
                            'processing' => 'В работе',
                            'completed' => 'Завершен',
                            'cancelled' => 'Отменен',
                        ];
                        $deliveryLabels = [
                            'pickup' => 'Самовывоз',
                            'delivery' => 'Доставка',
                        ];
                    @endphp

                    <div class="orders-list">
                        @foreach ($orders as $order)
                            <article class="order-card">
                                <div class="order-top">
                                    <div>
                                        <strong>Заказ #{{ $order->id }}</strong>
                                        <p>{{ $order->created_at?->format('d.m.Y H:i') }}</p>
                                    </div>
                                    <div class="order-status order-status-{{ $order->status }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </div>
                                </div>

                                <ul class="order-items">
                                    @foreach ($order->items as $item)
                                        <li>
                                            <div class="order-item-main">
                                                <div class="order-item-thumb">
                                                    @if ($item->product?->image)
                                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}">
                                                    @else
                                                        <span class="product-media-placeholder product-media-placeholder-sm">Нет фото</span>
                                                    @endif
                                                </div>
                                                <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                                            </div>
                                            <b>{{ number_format((float) $item->line_total, 0, ',', ' ') }} &#8381;</b>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="order-delivery">
                                    <p>
                                        <span>Получение:</span>
                                        <b>{{ $deliveryLabels[$order->delivery_type] ?? 'Самовывоз' }}</b>
                                    </p>
                                    @if ($order->delivery_type === 'delivery')
                                        <p>
                                            <span>Адрес:</span>
                                            <b>{{ $order->delivery_address }}</b>
                                        </p>
                                    @endif
                                </div>

                                <div class="order-bottom">
                                    <strong>Итого: {{ number_format((float) $order->total, 0, ',', ' ') }} &#8381;</strong>

                                    @if (in_array($order->status, ['new', 'processing'], true))
                                        <form method="POST" action="{{ route('dashboard.orders.cancel', $order) }}">
                                            @csrf
                                            <button class="btn btn-light" type="submit">Отменить заказ</button>
                                        </form>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </article>
        </div>
    </section>
@endsection
