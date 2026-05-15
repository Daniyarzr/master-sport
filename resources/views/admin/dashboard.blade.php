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
@endsection
