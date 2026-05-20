@extends('layouts.app')

@section('title', 'Master Sport | Статьи')
@section('description', 'Советы, обзоры и вдохновение для активного образа жизни.')

@section('content')
    <section class="section articles-hero">
        <div class="container">
            <div class="articles-hero-inner panel">
                <div>
                    <span class="eyebrow">Блог Master Sport</span>
                    <h1>Статьи</h1>
                    <p>Советы по тренировкам, обзоры экипировки и истории из мира спорта и путешествий.</p>
                </div>
                <div class="articles-hero-actions">
                    @auth
                        <a href="{{ route('articles.create') }}" class="btn btn-orange">
                            <i class="bi bi-plus-lg" aria-hidden="true"></i>
                            Написать статью
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light">Войти, чтобы публиковать</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($articles->isEmpty())
                <article class="panel articles-empty">
                    <i class="bi bi-journal-text" aria-hidden="true"></i>
                    <h2>Пока нет статей</h2>
                    <p>Будьте первым — поделитесь опытом с сообществом.</p>
                    @auth
                        <a href="{{ route('articles.create') }}" class="btn btn-orange">Создать статью</a>
                    @endauth
                </article>
            @else
                <div class="articles-grid">
                    @foreach ($articles as $article)
                        <article class="panel article-card">
                            <span class="article-category">{{ $article->category }}</span>
                            <h2>
                                <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                            </h2>
                            <p class="article-excerpt">{{ Str::limit(strip_tags($article->content), 160) }}</p>
                            <div class="article-meta">
                                <span>
                                    <i class="bi bi-person" aria-hidden="true"></i>
                                    {{ $article->user->name }}
                                </span>
                                <span>
                                    <i class="bi bi-calendar3" aria-hidden="true"></i>
                                    {{ $article->created_at?->format('d.m.Y') }}
                                </span>
                            </div>
                            <a class="article-read-more" href="{{ route('articles.show', $article) }}">
                                Читать далее
                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
