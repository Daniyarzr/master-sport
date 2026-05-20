@extends('layouts.admin')

@section('title', 'Категории | Админ')
@section('description', 'Управление категориями.')

@section('admin')
    <section class="section">
        <div class="container admin-grid">
            <article class="panel admin-card">
                <h1 style="margin-bottom: 0.85rem;">Категории</h1>

                <h2>Создать</h2>
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <label class="field">
                        <span>Название</span>
                        <input name="name" value="{{ old('name') }}" required>
                    </label>
                    <label class="field">
                        <span>Slug (необязательно)</span>
                        <input name="slug" value="{{ old('slug') }}" placeholder="tshirts">
                    </label>
                    <label class="field">
                        <span>Описание</span>
                        <textarea name="description" rows="3">{{ old('description') }}</textarea>
                    </label>
                    <button class="btn btn-orange" type="submit">Создать</button>
                </form>
            </article>

            <article class="panel admin-card">
                <h2>Список</h2>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Slug</th>
                                <th>Описание</th>
                                <th style="width: 260px;">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td colspan="4">
                                        <div style="display: grid; grid-template-columns: 1.2fr 1fr 2fr auto auto; gap: 0.5rem; align-items: center;">
                                            <form method="POST" action="{{ route('admin.categories.update', $category) }}" style="display: contents;">
                                                @csrf
                                                @method('PATCH')
                                                <input class="search-input" name="name" value="{{ $category->name }}" required>
                                                <input class="search-input" name="slug" value="{{ $category->slug }}" required>
                                                <input class="search-input" name="description" value="{{ $category->description }}" placeholder="Описание (необязательно)">
                                                <button class="btn btn-light" type="submit">Сохранить</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Удалить категорию?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-dark" type="submit">Удалить</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Категорий пока нет.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection

