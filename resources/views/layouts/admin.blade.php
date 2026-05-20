@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
    <div class="admin-page">
        <section class="section">
            <div class="container">
                <nav class="panel admin-nav" aria-label="Админ-навигация">
                    <a class="btn btn-light" href="{{ route('admin.dashboard') }}">Обзор</a>
                    <a class="btn btn-light" href="{{ route('admin.orders.index') }}">Заказы</a>
                    <a class="btn btn-light" href="{{ route('admin.products.index') }}">Товары</a>
                    <a class="btn btn-light" href="{{ route('admin.categories.index') }}">Категории</a>
                    <a class="btn btn-light" href="{{ route('admin.collections.index') }}">Коллекции</a>
                </nav>
            </div>
        </section>
        @yield('admin')
    </div>
@endsection
