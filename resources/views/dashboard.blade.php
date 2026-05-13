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
                                                    <img
                                                        src="{{ $item->product?->image ? asset('storage/'.$item->product->image) : asset('images/master-sport-banner.png') }}"
                                                        alt="{{ $item->product_name }}"
                                                    >
                                                </div>
                                                <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                                            </div>
                                            <b>{{ number_format((float) $item->line_total, 0, ',', ' ') }} ₽</b>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="order-bottom">
                                    <strong>Итого: {{ number_format((float) $order->total, 0, ',', ' ') }} ₽</strong>

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
