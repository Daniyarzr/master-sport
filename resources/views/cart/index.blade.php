@extends('layouts.app')

@section('title', 'Master Sport | Корзина')
@section('description', 'Корзина и оформление заказа Master Sport.')

@section('content')
    <section class="section">
        <div class="container cart-layout">
            <article class="panel cart-panel">
                <div class="section-head">
                    <h1>Корзина</h1>
                    @if ($items->isNotEmpty())
                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            <button class="btn btn-light" type="submit">Очистить</button>
                        </form>
                    @endif
                </div>

                @if ($items->isEmpty())
                    <p>В корзине пока пусто. Добавь товары из каталога.</p>
                    <div class="hero-actions">
                        <a class="btn btn-orange" href="{{ route('catalog') }}">Перейти в каталог</a>
                    </div>
                @else
                    <div class="cart-items">
                        @foreach ($items as $item)
                            <article class="cart-item">
                                <div class="cart-item-image">
                                    <img
                                        src="{{ $item['image'] ? asset('storage/'.$item['image']) : asset('images/master-sport-banner.png') }}"
                                        alt="{{ $item['name'] }}"
                                    >
                                </div>

                                <div class="cart-item-body">
                                    <h3>{{ $item['name'] }}</h3>
                                    <p>{{ number_format((float) $item['price'], 0, ',', ' ') }} &#8381; за шт.</p>
                                    <p>В наличии: {{ $item['stock'] }}</p>

                                    <div class="cart-item-actions">
                                        <div class="cart-qty-control">
                                            @if ((int) $item['quantity'] > 1)
                                                <form method="POST" action="{{ route('cart.update', $item['product_id']) }}">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="{{ (int) $item['quantity'] - 1 }}">
                                                    <button class="qty-btn" type="submit" aria-label="Уменьшить">−</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('cart.remove', $item['product_id']) }}">
                                                    @csrf
                                                    <button class="qty-btn" type="submit" aria-label="Удалить">−</button>
                                                </form>
                                            @endif

                                            <span class="qty-value">{{ $item['quantity'] }}</span>

                                            <form method="POST" action="{{ route('cart.add', $item['product_id']) }}">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button class="qty-btn" type="submit" aria-label="Увеличить" @disabled((int) $item['quantity'] >= (int) $item['stock'])>+</button>
                                            </form>
                                        </div>

                                        <form method="POST" action="{{ route('cart.remove', $item['product_id']) }}">
                                            @csrf
                                            <button class="btn btn-light" type="submit">Удалить</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="cart-item-total">
                                    {{ number_format((float) $item['line_total'], 0, ',', ' ') }} &#8381;
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </article>

            <aside class="panel checkout-panel">
                <h2>Оформление</h2>

                <div class="checkout-total-lines">
                    <p>Товары: <strong>{{ number_format((float) $itemsTotal, 0, ',', ' ') }} &#8381;</strong></p>
                    <p>Самовывоз: <strong>0 &#8381;</strong></p>
                    <p>Доставка: <strong>{{ number_format((float) $deliveryPrice, 0, ',', ' ') }} &#8381;</strong></p>
                </div>

                @if ($items->isEmpty())
                    <p>Сначала добавь товары в корзину.</p>
                @else
                    @php
                        $selectedDeliveryType = old('delivery_type', 'pickup');
                    @endphp

                    <form method="POST" action="{{ route('cart.checkout') }}" class="checkout-form checkout-delivery-form">
                        @csrf

                        <label class="field">
                            <span>Имя</span>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}" required>
                        </label>

                        <label class="field">
                            <span>Email</span>
                            <input type="email" name="customer_email" value="{{ old('customer_email', $user->email) }}" required>
                        </label>

                        <label class="field">
                            <span>Телефон</span>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone', $user->phone) }}" required>
                        </label>

                        <div class="field">
                            <span>Способ получения</span>
                            <div class="delivery-cards">
                                <label class="delivery-card">
                                    <input type="radio" name="delivery_type" value="pickup" @checked($selectedDeliveryType === 'pickup')>
                                    <span class="delivery-card-box">
                                        <span class="delivery-check" aria-hidden="true"></span>
                                        <span class="delivery-card-text">
                                            <b>Самовывоз</b>
                                            <small>{{ $pickupAddress }}</small>
                                        </span>
                                    </span>
                                </label>

                                <label class="delivery-card">
                                    <input type="radio" name="delivery_type" value="delivery" @checked($selectedDeliveryType === 'delivery')>
                                    <span class="delivery-card-box">
                                        <span class="delivery-check" aria-hidden="true"></span>
                                        <span class="delivery-card-text">
                                            <b>Доставка</b>
                                            <small>{{ number_format((float) $deliveryPrice, 0, ',', ' ') }} &#8381;</small>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <label class="field delivery-address-field @if ($selectedDeliveryType === 'delivery') is-visible @endif">
                            <span>Адрес доставки</span>
                            <input type="text" name="delivery_address" value="{{ old('delivery_address', $user->address) }}" placeholder="Город, улица, дом">
                        </label>

                        <label class="field">
                            <span>Комментарий</span>
                            <textarea name="comment" rows="4">{{ old('comment') }}</textarea>
                        </label>

                        <button class="btn btn-orange" type="submit">Оформить заказ</button>
                    </form>
                @endif
            </aside>
        </div>
    </section>
@endsection
