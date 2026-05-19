@extends('layouts.app')

@section('title', 'Master Sport | Новая статья')
@section('description', 'Создайте статью для блога Master Sport.')

@section('content')
    <section class="section">
        <div class="container article-form-wrap">
            <a class="article-back" href="{{ route('articles.index') }}">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                К списку статей
            </a>

            <article class="panel article-form-panel">
                <span class="eyebrow">Публикация</span>
                <h1>Новая статья</h1>
                <p>Расскажите о тренировках, снаряжении или путешествиях.</p>

                <form method="POST" action="{{ route('articles.add') }}" class="article-form">
                    @csrf

                    <label class="field">
                        <span>Заголовок</span>
                        <input type="text" name="title" value="{{ old('title') }}" required>
                    </label>

                    <label class="field">
                        <span>Категория</span>
                        <select name="category" required>
                            @foreach (['хайкинг', 'велопутешествия', 'бег', 'путешествия', 'спорт'] as $cat)
                                <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="field">
                        <span>Текст статьи</span>
                        <textarea name="content" rows="10" required>{{ old('content') }}</textarea>
                    </label>

                    <div class="hero-actions">
                        <button type="submit" class="btn btn-orange">Опубликовать</button>
                        <a class="btn btn-light" href="{{ route('articles.index') }}">Отмена</a>
                    </div>
                </form>
            </article>
        </div>
    </section>
@endsection
