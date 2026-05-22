@extends('layouts.admin')

@section('title', 'Редактировать коллекцию | Админ')
@section('description', 'Редактирование коллекции.')

@section('admin')
    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <div class="section-head">
                    <h1>Редактировать коллекцию: {{ $collection->name }}</h1>
                    <a href="{{ route('admin.collections.index') }}">← к списку</a>
                </div>

                <form method="POST" action="{{ route('admin.collections.update', $collection) }}">
                    @csrf
                    @method('PATCH')

                    <label class="field">
                        <span>Название</span>
                        <input name="name" value="{{ old('name', $collection->name) }}" required>
                    </label>
                    <label class="field">
                        <span>Slug</span>
                        <input name="slug" value="{{ old('slug', $collection->slug) }}" required>
                    </label>
                    <label class="field">
                        <span>Описание</span>
                        <textarea name="description" rows="4">{{ old('description', $collection->description) }}</textarea>
                    </label>
                    <label class="check">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $collection->is_active))>
                        <span>Активна</span>
                    </label>

                    <div class="hero-actions" style="margin-top: 0.8rem;">
                        <button class="btn btn-orange" type="submit">Сохранить</button>
                        <a class="btn btn-light" href="{{ route('admin.collections.index') }}">Отмена</a>
                    </div>
                </form>
            </article>
        </div>
    </section>
@endsection