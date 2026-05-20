@extends('layouts.admin')

@section('title', 'Заказы | Админ')
@section('description', 'Управление заказами Master Sport.')

@section('admin')
    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <div class="section-head">
                    <h1>Заказы</h1>
                    <span>Всего: {{ $orders->total() }}</span>
                </div>

                <form method="GET" action="{{ route('admin.orders.index') }}" class="filter-actions" style="margin: 0 0 0.8rem;">
                    <label class="field" style="max-width: 220px;">
                        <span>Статус</span>
                        <select name="status">
                            <option value="">Все</option>
                            @foreach ($statuses as $s)
                                <option value="{{ $s }}" @selected($s === $status)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="btn btn-orange" type="submit">Фильтр</button>
                    <a class="btn btn-light" href="{{ route('admin.orders.index') }}">Сбросить</a>
                </form>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Клиент</th>
                                <th>Статус</th>
                                <th>Сумма</th>
                                <th>Создан</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user?->name ?? $order->customer_name }}</td>
                                    <td>
                                        <span class="order-status order-status-{{ $order->status }}">{{ $order->status }}</span>
                                    </td>
                                    <td>{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</td>
                                    <td>{{ $order->created_at?->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <a class="btn btn-light" href="{{ route('admin.orders.show', $order) }}">Открыть</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Заказов нет.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pager" style="margin-top: 0.9rem;">
                    {{ $orders->links() }}
                </div>
            </article>
        </div>
    </section>
@endsection

