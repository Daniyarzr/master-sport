@extends('layouts.admin')

@section('title', 'Товары | Админ')
@section('description', 'Управление товарами.')

@section('admin')
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h1>Товары</h1>
                <span>Всего: {{ $products->total() }}</span>
            </div>

            <article class="admin-card panel">
                <h2>Добавить товар</h2>
                <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="admin-form-grid">
                        <label class="field span-2">
                            <span>Название</span>
                            <input type="text" name="name" value="{{ old('name') }}" required>
                        </label>
                        <label class="field span-2">
                            <span>Описание</span>
                            <textarea name="description" rows="3" required>{{ old('description') }}</textarea>
                        </label>
                        <label class="field">
                            <span>Цена, ₽</span>
                            <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
                        </label>
                        <label class="field">
                            <span>Остаток</span>
                            <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" required>
                        </label>
                        <label class="field span-2">
                            <span>Изображение товара</span>
                            <input type="file" name="image" accept="image/*" required>
                        </label>
                        <label class="field">
                            <span>Категория</span>
                            <select name="category_id" required>
                                <option value="">Выберите</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <label class="field">
                            <span>Коллекция</span>
                            <select name="collection_id">
                                <option value="">Без коллекции</option>
                                @foreach ($collections as $collection)
                                    <option value="{{ $collection->id }}" @selected((string) old('collection_id') === (string) $collection->id)>
                                        {{ $collection->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <label class="field">
                            <span>Бренд</span>
                            <input type="text" name="brand" value="{{ old('brand', 'Master Sport') }}" required>
                        </label>
                        <label class="field">
                            <span>Размер</span>
                            <input type="text" name="size" value="{{ old('size', 'M') }}" required>
                        </label>
                        <label class="field">
                            <span>Цвет</span>
                            <input type="text" name="color" value="{{ old('color') }}" required>
                        </label>
                        <label class="field">
                            <span>Пол</span>
                            <select name="gender" required>
                                <option value="unisex" @selected(old('gender') === 'unisex')>Унисекс</option>
                                <option value="male" @selected(old('gender') === 'male')>Мужское</option>
                                <option value="female" @selected(old('gender') === 'female')>Женское</option>
                            </select>
                        </label>
                    </div>
                    <button class="btn btn-dark" type="submit" style="margin-top: 0.75rem;">Сохранить товар</button>
                </form>
            </article>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <h2>Список товаров</h2>

                <div class="admin-table-wrap">
                    <table class="admin-table">
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
