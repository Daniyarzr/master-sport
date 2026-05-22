@extends('layouts.admin')

@section('title', 'Админ-панель | Master Sport')
@section('description', 'Панель управления Master Sport.')

@section('admin')
    <section class="admin-hero section">
        <h1>Админ-панель</h1>
        <p>Добавляйте товары в каталог, создавайте пользователей и назначайте права администратора.</p>
    </section>

    <section class="admin-stats section" aria-label="Базовая статистика">
        <article class="admin-stat">
            <strong>{{ $stats['products'] }}</strong>
            <span>Товаров в базе</span>
        </article>
        <article class="admin-stat">
            <strong>{{ $stats['users'] }}</strong>
            <span>Пользователей</span>
        </article>
        <article class="admin-stat">
            <strong>{{ $stats['admins'] }}</strong>
            <span>Администраторов</span>
        </article>
    </section>

    <section class="admin-card panel section">
        <h2>Бизнес-статистика</h2>
        <div class="admin-kpi-grid">
            <article class="admin-kpi">
                <span>Выручка</span>
                <strong>{{ number_format($totalRevenue, 0, ',', ' ') }} ₽</strong>
                <small>Без отменённых заказов</small>
            </article>
            <article class="admin-kpi">
                <span>Всего заказов</span>
                <strong>{{ $totalOrders }}</strong>
                <small>Обработанные и новые</small>
            </article>
            <article class="admin-kpi">
                <span>Отзывы на модерации</span>
                <strong>{{ $pendingReviewsCount }}</strong>
                <small>Требуют проверки</small>
            </article>
            <article class="admin-kpi">
                <span>Средний рейтинг</span>
                <strong>{{ number_format($averageApprovedRating, 1) }}/5</strong>
                <small>По одобренным отзывам</small>
            </article>
        </div>
    </section>

    <section class="admin-grid admin-overview-grid section">
        <article class="admin-card panel">
            <div class="section-head">
                <h2>Последние заказы</h2>
                <a href="{{ route('admin.orders.index') }}">Все заказы</a>
            </div>

            @php
                $statusLabels = [
                    'new' => 'Новый',
                    'pending' => 'Ожидает',
                    'processing' => 'В обработке',
                    'completed' => 'Выполнен',
                    'cancelled' => 'Отменён',
                ];
            @endphp

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Клиент</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user?->name ?? $order->customer_name ?? 'Гость' }}</td>
                                <td>{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</td>
                                <td>
                                    <span class="order-status order-status-{{ $order->status }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at?->format('d.m.Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Заказов пока нет.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="admin-card panel">
            <div class="section-head">
                <h2>Отзывы на модерации</h2>
                <a href="{{ route('admin.reviews.index') }}">Все отзывы</a>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Автор</th>
                            <th>Оценка</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingReviews as $review)
                            <tr>
                                <td>
                                    @if ($review->product)
                                        <a class="admin-review-product" href="{{ route('catalog.show', $review->product->slug) }}" target="_blank" rel="noopener noreferrer">
                                            {{ Str::limit($review->product->name, 28) }}
                                        </a>
                                    @else
                                        <span class="field-hint">Товар удалён</span>
                                    @endif
                                </td>
                                <td>{{ $review->getAuthorName() }}</td>
                                <td>
                                    <div class="review-stars" aria-label="Оценка {{ $review->rating }} из 5">
                                        @for ($star = 1; $star <= 5; $star++)
                                            <span class="{{ $star <= $review->rating ? 'is-filled' : '' }}">★</span>
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-inline-actions">
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-light admin-btn-small" type="submit">Одобрить</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-dark admin-btn-small" type="submit">Отклонить</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Новых отзывов на модерацию нет.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </section>

    <section class="admin-card panel section">
        <h2>Последние товары</h2>
        <div class="admin-products-list">
            @forelse ($products as $product)
                <article class="admin-product-item">
                    <div>
                        <strong>{{ $product->name }}</strong>
                        <span>
                            {{ $product->category?->name ?? 'Без категории' }}
                            · {{ $product->collection?->name ?? 'Без коллекции' }}
                            · {{ $product->stock }} шт.
                        </span>
                    </div>
                    <em>{{ number_format($product->price, 0, ',', ' ') }} ₽</em>
                </article>
            @empty
                <p class="empty-message">Товаров пока нет — добавьте первый в разделе «Товары».</p>
            @endforelse
        </div>
    </section>
@endsection
