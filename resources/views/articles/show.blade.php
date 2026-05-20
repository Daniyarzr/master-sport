@extends('layouts.app')

@section('title', 'Master Sport | ' . $article->title)
@section('description', Str::limit(strip_tags($article->content), 160))

@section('content')
    <section class="section">
        <div class="container article-show-wrap">
            <a class="article-back" href="{{ route('articles.index') }}">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                Все статьи
            </a>

            <article class="panel article-show">
                <span class="article-category">{{ $article->category }}</span>
                <h1>{{ $article->title }}</h1>
                <div class="article-meta article-meta-lg">
                    <span>
                        <i class="bi bi-person" aria-hidden="true"></i>
                        {{ $article->user->name }}
                    </span>
                    <span>
                        <i class="bi bi-calendar3" aria-hidden="true"></i>
                        {{ $article->created_at?->format('d.m.Y') }}
                    </span>
                </div>
                <div class="article-content">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </article>
        </div>
    </section>
@endsection
