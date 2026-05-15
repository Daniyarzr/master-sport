@extends('layouts.app')

@section('title', 'Master Sport | Регистрация')
@section('description', 'Регистрация в Master Sport: имя, email и телефон.')

@section('content')
    <section class="section">
        <div class="container auth-wrap">
            <article class="panel auth-card">
                <h1>Регистрация</h1>
                <p>Создай аккаунт для работы с личным кабинетом.</p>

                <form method="POST" action="{{ route('register.store') }}" class="auth-form">
                    @csrf
                    <label class="field">
                        <span>Имя</span>
                        <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
                    </label>

                    <label class="field">
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    </label>

                    <label class="field">
                        <span>Телефон</span>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                            autocomplete="tel"
                            placeholder="+79001234567"
                        >
                    </label>

                    <label class="field">
                        <span>Пароль</span>
                        <input type="password" name="password" required autocomplete="new-password">
                    </label>

                    <label class="field">
                        <span>Подтверждение пароля</span>
                        <input type="password" name="password_confirmation" required autocomplete="new-password">
                    </label>

                    <button class="btn btn-dark" type="submit">Зарегистрироваться</button>
                </form>

                <p class="auth-meta">
                    Уже есть аккаунт?
                    <a href="{{ route('login') }}">Войти</a>
                </p>
            </article>
        </div>
    </section>
@endsection
