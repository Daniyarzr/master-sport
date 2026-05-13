@extends('layouts.app')

@section('title', 'Master Sport | Admin')
@section('description', 'Админ-раздел Master Sport.')

@section('content')
    <section class="section">
        <div class="container">
            <article class="panel admin-panel">
                <div class="section-head">
                    <h1>Админ</h1>
                    <span>Только для роли admin</span>
                </div>

                <div class="stats-grid">
                    <div><span>Пользователи</span><b>{{ $usersCount }}</b></div>
                    <div><span>Заказы</span><b>{{ $ordersCount }}</b></div>
                    <div><span>Новые заказы</span><b>{{ $newOrdersCount }}</b></div>
                    <div><span>Товары</span><b>{{ $productsCount }}</b></div>
                </div>
            </article>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <article class="panel orders-panel">
                <h2>Последние заказы</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Клиент</th>
                                <th>Статус</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user?->name ?? '—' }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Пока нет заказов</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection
