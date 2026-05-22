@extends('layouts.admin')

@section('title', 'Коллекции | Админ')
@section('description', 'Управление коллекциями.')

@section('admin')
    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <h1 style="margin-bottom: 0.85rem;">Коллекции</h1>

                <h2>Создать</h2>
                <form method="POST" action="{{ route('admin.collections.store') }}">
                    @csrf
                    <label class="field">
                        <span>Название</span>
                        <input name="name" value="{{ old('name') }}" required>
                    </label>
                    <label class="field">
                        <span>Slug (необязательно)</span>
                        <input name="slug" value="{{ old('slug') }}" placeholder="core-line">
                    </label>
                    <label class="field">
                        <span>Описание</span>
                        <textarea name="description" rows="3">{{ old('description') }}</textarea>
                    </label>
                    <label class="check">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>
                        <span>Активна</span>
                    </label>
                    <button class="btn btn-orange" type="submit">Создать</button>
                </form>
            </article>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <h2>Список</h2>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Slug</th>
                                <th>Активна</th>
                                <th>Описание</th>
                                <th style="width: 240px;">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($collections as $collection)
                                <tr>
                                    <td>{{ $collection->name }}</td>
                                    <td>{{ $collection->slug }}</td>
                                    <td>{{ $collection->is_active ? 'Да' : 'Нет' }}</td>
                                    <td>{{ $collection->description ?: '—' }}</td>
                                    <td>
                                        <a class="btn btn-light" href="{{ route('admin.collections.edit', $collection) }}">Редактировать</a>
                                        <form method="POST" action="{{ route('admin.collections.destroy', $collection) }}" style="display: inline;" onsubmit="return confirm('Удалить коллекцию?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-dark" type="submit">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Коллекций пока нет.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection