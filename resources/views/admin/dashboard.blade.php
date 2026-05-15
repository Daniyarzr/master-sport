@extends('layouts.admin')

@section('title', 'Админ-панель')

@section('content')
    <section class="admin-hero">
        <h1>Админ-панель</h1>
        <p>Добавляйте товары в каталог, создавайте пользователей и назначайте права администратора.</p>
    </section>

    <section class="admin-stats" aria-label="Статистика">
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

    <section class="admin-grid">
        <article class="admin-card">
            <h2>Добавить товар</h2>
            <form action="{{ route('admin.products.store') }}" method="post" class="admin-form">
                @csrf
                <div class="admin-form-grid">
                    <div class="filter-group span-2">
                        <label for="name">Название</label>
                        <input class="search-input" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="filter-group span-2">
                        <label for="description">Описание</label>
                        <textarea class="search-input" id="description" name="description" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="filter-group">
                        <label for="price">Цена, ₽</label>
                        <input class="search-input" id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" required>
                    </div>
                    <div class="filter-group">
                        <label for="quantity">Количество</label>
                        <input class="search-input" id="quantity" name="quantity" type="number" min="0" value="{{ old('quantity', 0) }}" required>
                    </div>
                    <div class="filter-group span-2">
                        <label for="image">Путь к изображению</label>
                        <input class="search-input" id="image" name="image" value="{{ old('image', 'images/products/aero-tee-blue.svg') }}" placeholder="images/products/..." required>
                    </div>
                    <div class="filter-group">
                        <label for="category">Категория</label>
                        <input class="search-input" id="category" name="category" value="{{ old('category') }}" required>
                    </div>
                    <div class="filter-group">
                        <label for="collection">Коллекция</label>
                        <input class="search-input" id="collection" name="collection" value="{{ old('collection') }}" required>
                    </div>
                    <div class="filter-group">
                        <label for="brand">Бренд</label>
                        <input class="search-input" id="brand" name="brand" value="{{ old('brand', 'Master Sport') }}" required>
                    </div>
                    <div class="filter-group">
                        <label for="size">Размер</label>
                        <input class="search-input" id="size" name="size" value="{{ old('size', 'M') }}" required>
                    </div>
                    <div class="filter-group">
                        <label for="color">Цвет</label>
                        <input class="search-input" id="color" name="color" value="{{ old('color') }}" required>
                    </div>
                    <div class="filter-group">
                        <label for="gender">Пол</label>
                        <select class="select-input" id="gender" name="gender" required>
                            <option value="unisex" @selected(old('gender') === 'unisex')>Унисекс</option>
                            <option value="male" @selected(old('gender') === 'male')>Мужское</option>
                            <option value="female" @selected(old('gender') === 'female')>Женское</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-accent" type="submit" style="margin-top: 0.75rem;">Сохранить товар</button>
            </form>
        </article>

        <article class="admin-card">
            <h2>Добавить пользователя</h2>
            <form action="{{ route('admin.users.store') }}" method="post">
                @csrf
                <div class="filter-group">
                    <label for="user_name">Имя</label>
                    <input class="search-input" id="user_name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="filter-group">
                    <label for="user_email">Email</label>
                    <input class="search-input" id="user_email" name="email" type="email" value="{{ old('email') }}" required>
                </div>
                <div class="filter-group">
                    <label for="user_password">Пароль</label>
                    <input class="search-input" id="user_password" name="password" type="password" required>
                </div>
                <div class="filter-group">
                    <label for="user_password_confirmation">Повтор пароля</label>
                    <input class="search-input" id="user_password_confirmation" name="password_confirmation" type="password" required>
                </div>
                <label class="admin-checkbox">
                    <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin'))>
                    Назначить администратором
                </label>
                <button class="btn btn-primary" type="submit" style="margin-top: 0.85rem;">Создать пользователя</button>
            </form>
        </article>
    </section>

    <section class="admin-card" style="margin-bottom: 1rem;">
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
                                    <select class="select-input" name="role">
                                        <option value="user" @selected($user->role === \App\Models\User::ROLE_USER)>Пользователь</option>
                                        <option value="admin" @selected($user->role === \App\Models\User::ROLE_ADMIN)>Админ</option>
                                    </select>
                                    <button class="btn btn-outline" type="submit">Применить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="admin-card">
        <h2>Последние товары</h2>
        <div class="admin-products-list">
            @forelse ($products as $product)
                <article class="admin-product-item">
                    <div>
                        <strong>{{ $product->name }}</strong>
                        <span>{{ $product->category }} · {{ $product->collection }} · {{ $product->quantity }} шт.</span>
                    </div>
                    <em>{{ number_format($product->price, 0, ',', ' ') }} ₽</em>
                </article>
            @empty
                <p class="empty-message">Товаров пока нет — добавьте первый через форму выше.</p>
            @endforelse
        </div>
    </section>
@endsection
