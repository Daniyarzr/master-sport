@extends('layouts.admin')

@section('title', 'Редактировать контакт | Админ')
@section('description', 'Редактирование контакта сайта.')

@section('admin')
    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <div class="section-head">
                    <h1>Редактировать контакт: {{ $contact->label }}</h1>
                    <a href="{{ route('admin.contacts.index') }}">← к списку</a>
                </div>

                <form method="POST" action="{{ route('admin.contacts.update', $contact) }}">
                    @csrf
                    @method('PATCH')

                    <label class="field">
                        <span>Ключ</span>
                        <input name="key" value="{{ old('key', $contact->key) }}" required>
                    </label>
                    <label class="field">
                        <span>Тип</span>
                        <select name="type" required>
                            @foreach ($types as $typeValue => $typeLabel)
                                <option value="{{ $typeValue }}" @selected(old('type', $contact->type) === $typeValue)>{{ $typeLabel }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field">
                        <span>Подпись</span>
                        <input name="label" value="{{ old('label', $contact->label) }}" required>
                    </label>
                    <label class="field">
                        <span>Значение</span>
                        <input name="value" value="{{ old('value', $contact->value) }}" required>
                    </label>
                    <label class="field">
                        <span>Href (необязательно)</span>
                        <input name="href" value="{{ old('href', $contact->href) }}" placeholder="tel:+73412900000">
                    </label>
                    <label class="field">
                        <span>Порядок</span>
                        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $contact->sort_order) }}">
                    </label>
                    <label class="check">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $contact->is_active))>
                        <span>Активен</span>
                    </label>

                    <div class="hero-actions" style="margin-top: 0.8rem;">
                        <button class="btn btn-orange" type="submit">Сохранить</button>
                        <a class="btn btn-light" href="{{ route('admin.contacts.index') }}">Отмена</a>
                    </div>
                </form>
            </article>
        </div>
    </section>
@endsection