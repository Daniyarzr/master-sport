@extends('layouts.admin')

@section('title', 'Админ-панель | Master Sport')
@section('description', 'Панель управления Master Sport.')

@section('admin')
    <section class="admin-hero section">
        <h1>Админ-панель</h1>
        <p>Добавляйте товары в каталог, создавайте пользователей и назначайте права администратора.</p>
    </section>

    <section class="admin-stats section" aria-label="Статистика">
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

    <section class="admin-grid section">
        <article class="admin-card panel">
            <h2>Добавить товар</h2>
            <form action="{{ route('admin.products.store') }}" method="post">
                @csrf
                <div class="admin-form-grid">
                    <label class="field span-2">
                        <span>Название</span>
                        <input type="text" name="name" value="{{ old('name') }}" required>
                    </label>
                    <label class="field span-2">
                        <span>Описание</span>
                        <textarea name="description" rows="3" required>{{ old('description') }}</textarea>
                    </label>
                    <label class="field">
                        <span>Цена, ₽</span>
                        <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
                    </label>
                    <label class="field">
                        <span>Остаток</span>
                        <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" required>
                    </label>
                    <label class="field span-2">
                        <span>Путь к изображению</span>
                        <input type="text" name="image" value="{{ old('image', 'products/aero-tee-blue.svg') }}" placeholder="products/..." required>
                    </label>
                    <label class="field">
                        <span>Категория</span>
                        <select name="category_id" required>
                            <option value="">Выберите</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field">
                        <span>Коллекция</span>
                        <select name="collection_id">
                            <option value="">Без коллекции</option>
                            @foreach ($collections as $collection)
                                <option value="{{ $collection->id }}" @selected((string) old('collection_id') === (string) $collection->id)>
                                    {{ $collection->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field">
                        <span>Бренд</span>
                        <input type="text" name="brand" value="{{ old('brand', 'Master Sport') }}" required>
                    </label>
                    <label class="field">
                        <span>Размер</span>
                        <input type="text" name="size" value="{{ old('size', 'M') }}" required>
                    </label>
                    <label class="field">
                        <span>Цвет</span>
                        <input type="text" name="color" value="{{ old('color') }}" required>
                    </label>
                    <label class="field">
                        <span>Пол</span>
                        <select name="gender" required>
                            <option value="unisex" @selected(old('gender') === 'unisex')>Унисекс</option>
                            <option value="male" @selected(old('gender') === 'male')>Мужское</option>
                            <option value="female" @selected(old('gender') === 'female')>Женское</option>
                        </select>
                    </label>
                </div>
                <button class="btn btn-dark" type="submit" style="margin-top: 0.75rem;">Сохранить товар</button>
            </form>
        </article>

        <article class="admin-card panel">
            <h2>Добавить пользователя</h2>
            <form action="{{ route('admin.users.store') }}" method="post">
                @csrf
                <label class="field">
                    <span>Имя</span>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </label>
                <label class="field">
                    <span>Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                <label class="field">
                    <span>Телефон</span>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+79000000000">
                </label>
                <label class="field">
                    <span>Пароль</span>
                    <input type="password" name="password" required>
                </label>
                <label class="field">
                    <span>Повтор пароля</span>
                    <input type="password" name="password_confirmation" required>
                </label>
                <label class="check">
                    <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin'))>
                    <span>Назначить администратором</span>
                </label>
                <button class="btn btn-orange" type="submit" style="margin-top: 0.85rem;">Создать пользователя</button>
            </form>
        </article>
    </section>

    <section class="admin-card panel section">
        <h2>Пользователи и роли</h2>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge {{ $user->isAdmin() ? 'is-admin' : 'is-user' }}">
                                    {{ $user->isAdmin() ? 'Админ' : 'Пользователь' }}
                                </span>
                            </td>
                            <td>
                                <form class="admin-role-form" action="{{ route('admin.users.role', $user) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role">
                                        <option value="user" @selected($user->role === \App\Models\User::ROLE_USER)>Пользователь</option>
                                        <option value="admin" @selected($user->role === \App\Models\User::ROLE_ADMIN)>Админ</option>
                                    </select>
                                    <button class="btn btn-light" type="submit">Применить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
                <p class="empty-message">Товаров пока нет — добавьте первый через форму выше.</p>
            @endforelse
        </div>
    </section>
<h4 class="mb-4">📊 Панель статистики</h4>

<!-- Карточки с метриками -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-primary h-100">
            <div class="card-body">
                <h6 class="card-title">💰 Общая выручка</h6>
                <h3 class="mb-0">{{ number_format($totalRevenue ?? 0, 0, '.', ' ') }} ₽</h3>
                <small class="text-white-50">{{ $totalOrders ?? 0 }} заказов</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success h-100">
            <div class="card-body">
                <h6 class="card-title">👥 Пользователи</h6>
                <h3 class="mb-0">{{ $totalUsers ?? 0 }}</h3>
                <small class="text-white-50">Зарегистрировано</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning h-100">
            <div class="card-body">
                <h6 class="card-title">📝 Отзывы</h6>
                <h3 class="mb-0">{{ $pendingReviews ?? 0 }}</h3>
                <small class="text-white-50">На модерации</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-info h-100">
            <div class="card-body">
                <h6 class="card-title">⭐ Средний рейтинг</h6>
                <h3 class="mb-0">{{ number_format($avgRating ?? 0, 1) }}/5</h3>
                <small class="text-white-50">По одобренным отзывам</small>
            </div>
        </div>
    </div>
</div>

<!-- Последние заказы и отзывы -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-cart-check me-2"></i>Последние заказы</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Все заказы</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Клиент</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user?->name ?? 'Гость' }}</td>
                                <td>{{ number_format($order->total, 0, '.', ' ') }} ₽</td>
                                <td>
                                    @php
                                        $statusBadges = [
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Ожидает',
                                            'processing' => 'В обработке',
                                            'completed' => 'Выполнен',
                                            'cancelled' => 'Отменён'
                                        ];
                                        $badge = $statusBadges[$order->status] ?? 'secondary';
                                        $label = $statusLabels[$order->status] ?? $order->status;
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                                </td>
                                <td>{{ $order->created_at->format('d.m.Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">Нет заказов</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-chat-square-text me-2"></i>Отзывы на модерации</span>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-primary">Все отзывы</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Товар</th>
                            <th>Автор</th>
                            <th>⭐</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentReviews ?? [] as $review)
                            <tr>
                                <td>
                                    <a href="{{ route('catalog.show', $review->product->slug) }}" target="_blank" class="text-decoration-none">
                                        {{ Str::limit($review->product->name, 25) }}
                                    </a>
                                </td>
                                <td>{{ $review->getAuthorName() }}</td>
                                <td>{{ str_repeat('★', $review->rating) }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-outline-success" title="Одобрить">✓</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-outline-danger" title="Отклонить">✗</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Нет отзывов на модерации 🎉</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection