@extends('layouts.app')

@section('title', 'Master Sport | Вход')
@section('description', 'Вход в личный кабинет Master Sport.')

@section('content')
    <section class="section">
        <div class="container auth-wrap">
            <article class="panel auth-card">
                <h1>Вход</h1>
                <p>Войди в кабинет, чтобы смотреть данные профиля и состояние магазина.</p>

                <form method="POST" action="{{ route('login.store') }}" class="auth-form">
                    @csrf
                    <label class="field">
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    </label>

                    <label class="field">
                        <span>Пароль</span>
                        <input type="password" name="password" required autocomplete="current-password">
                    </label>

                    <label class="check">
                        <input type="checkbox" name="remember">
                        <span>Запомнить меня</span>
                    </label>

                    <button class="btn btn-dark" type="submit">Войти</button>
                </form>

                <p class="auth-meta">
                    Нет аккаунта?
                    <a href="{{ route('register') }}">Создать</a>
                </p>
            </article>
        </div>
    </section>
@endsection
