@extends('layouts.admin')

@section('title', 'Пользователи | Админ')
@section('description', 'Управление пользователями и ролями.')

@section('admin')
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h1>Пользователи</h1>
                <span>Всего: {{ $users->count() }}</span>
            </div>

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
        </div>
    </section>

    <section class="section">
        <div class="container">
            <article class="admin-card panel">
                <h2>Пользователи и роли</h2>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Телефон</th>
                                <th>Роль</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?: '—' }}</td>
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
                            @empty
                                <tr>
                                    <td colspan="5">Пользователей пока нет.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection
