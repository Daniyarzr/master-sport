@extends('layouts.app')

@section('title', 'Master Sport')

@section('content')
    <section class="section">
        <div class="container">
            <article class="panel">
                <h1>Master Sport</h1>
                <p>Стартовая страница проекта. Основной контент доступен на главной и в каталоге.</p>
                <div class="hero-actions">
                    <a class="btn btn-dark" href="{{ route('home') }}">На главную</a>
                    <a class="btn btn-light" href="{{ route('catalog') }}">В каталог</a>
                </div>
            </article>
        </div>
    </section>
@endsection
