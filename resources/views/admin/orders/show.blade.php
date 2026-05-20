@extends('layouts.admin')

@section('title', "Заказ #{$order->id} | Админ")
@section('description', 'Просмотр и управление заказом.')

@section('admin')
    @php
        $deliveryLabels = [
            'pickup' => 'Самовывоз',
            'delivery' => 'Доставка',
        ];
    @endphp

    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <div class="section-head">
                    <h1>Заказ #{{ $order->id }}</h1>
                    <a href="{{ route('admin.orders.index') }}">← к списку</a>
                </div>

                <div class="stats-grid">
                    <div><span>Статус</span><b>{{ $order->status }}</b></div>
                    <div><span>Сумма</span><b>{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</b></div>
                    <div><span>Создан</span><b>{{ $order->created_at?->format('d.m.Y H:i') }}</b></div>
                </div>

                <form method="POST" action="{{ route('admin.orders.status', $order) }}" style="margin-top: 0.8rem;">
                    @csrf
                    @method('PATCH')
                    <div class="filter-actions">
                        <label class="field" style="max-width: 240px;">
                            <span>Изменить статус</span>
                            <select name="status" required>
                                @foreach ($statuses as $s)
                                    <option value="{{ $s }}" @selected($order->status === $s)>{{ $s }}</option>
                                @endforeach
                            </select>
                        </label>
                        <button class="btn btn-orange" type="submit">Сохранить</button>
                    </div>
                </form>

                <div class="order-delivery" style="margin-top: 0.9rem;">
                    <p><span>Клиент</span><b>{{ $order->customer_name }}</b></p>
                    <p><span>Email</span><b>{{ $order->customer_email }}</b></p>
                    <p><span>Телефон</span><b>{{ $order->customer_phone }}</b></p>
                    <p><span>Получение</span><b>{{ $deliveryLabels[$order->delivery_type] ?? $order->delivery_type }}</b></p>
                    <p><span>Адрес</span><b>{{ $order->delivery_address ?: '—' }}</b></p>
                    <p><span>Доставка</span><b>{{ number_format((float) $order->delivery_cost, 0, ',', ' ') }} ₽</b></p>
                    @if ($order->comment)
                        <p><span>Комментарий</span><b>{{ $order->comment }}</b></p>
                    @endif
                </div>
            </article>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <h2>Товары</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Кол-во</th>
                                <th>Итого</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ number_format((float) $item->product_price, 0, ',', ' ') }} ₽</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format((float) $item->line_total, 0, ',', ' ') }} ₽</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection

