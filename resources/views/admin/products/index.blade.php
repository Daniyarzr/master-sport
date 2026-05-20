@extends('layouts.admin')

@section('title', 'Товары | Админ')
@section('description', 'Управление товарами.')

@section('admin')
    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <div class="section-head">
                    <h1>Товары</h1>
                    <span>Всего: {{ $products->total() }}</span>
                </div>

                <p style="margin-bottom: 0.75rem;">
                    Добавление нового товара доступно на странице <a href="{{ route('admin.dashboard') }}">Обзор</a>.
                </p>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Категория</th>
                                <th>Коллекция</th>
                                <th>Цена</th>
                                <th>Остаток</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>#{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category?->name ?? '—' }}</td>
                                    <td>{{ $product->collection?->name ?? '—' }}</td>
                                    <td>{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</td>
                                    <td>{{ $product->stock }}</td>
                                    <td style="white-space: nowrap;">
                                        <a class="btn btn-light" href="{{ route('admin.products.edit', $product) }}">Редактировать</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Удалить товар?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-dark" type="submit">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Товаров пока нет.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pager" style="margin-top: 0.9rem;">
                    {{ $products->links() }}
                </div>
            </article>
        </div>
    </section>
@endsection

