@extends('layouts.admin')

@section('title', 'Контакты | Админ')
@section('description', 'Управление контактами сайта.')

@section('admin')
    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <h1 style="margin-bottom: 0.85rem;">Контакты</h1>

                <h2>Добавить</h2>
                <form method="POST" action="{{ route('admin.contacts.store') }}">
                    @csrf
                    <label class="field">
                        <span>Ключ (латиница, цифры, underscore)</span>
                        <input name="key" value="{{ old('key') }}" placeholder="phone_main" required>
                    </label>
                    <label class="field">
                        <span>Тип</span>
                        <select name="type" required>
                            @foreach ($types as $typeValue => $typeLabel)
                                <option value="{{ $typeValue }}" @selected(old('type') === $typeValue)>{{ $typeLabel }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field">
                        <span>Подпись</span>
                        <input name="label" value="{{ old('label') }}" placeholder="Телефон" required>
                    </label>
                    <label class="field">
                        <span>Значение</span>
                        <input name="value" value="{{ old('value') }}" placeholder="+7 (3412) 90-00-00" required>
                    </label>
                    <label class="field">
                        <span>Href (необязательно)</span>
                        <input name="href" value="{{ old('href') }}" placeholder="tel:+73412900000">
                    </label>
                    <label class="field">
                        <span>Порядок</span>
                        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', 100) }}">
                    </label>
                    <label class="check">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>
                        <span>Активен</span>
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
                                <th>Ключ</th>
                                <th>Тип</th>
                                <th>Подпись</th>
                                <th>Значение</th>
                                <th>Href</th>
                                <th>Порядок</th>
                                <th>Активен</th>
                                <th style="width: 240px;">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->key }}</td>
                                    <td>{{ $types[$contact->type] ?? $contact->type }}</td>
                                    <td>{{ $contact->label }}</td>
                                    <td>{{ $contact->value }}</td>
                                    <td>{{ $contact->href ?: '—' }}</td>
                                    <td>{{ $contact->sort_order }}</td>
                                    <td>{{ $contact->is_active ? 'Да' : 'Нет' }}</td>
                                    <td>
                                        <a class="btn btn-light" href="{{ route('admin.contacts.edit', $contact) }}">Редактировать</a>
                                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display: inline;" onsubmit="return confirm('Удалить контакт?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-dark" type="submit">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">Контактов пока нет.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection