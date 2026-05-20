@extends('layouts.admin')

@section('title', 'Редактировать товар | Админ')
@section('description', 'Редактирование товара.')

@section('admin')
    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <div class="section-head">
                    <h1>Редактировать: {{ $product->name }}</h1>
                    <a href="{{ route('admin.products.index') }}">← к списку</a>
                </div>

                <form method="POST" action="{{ route('admin.products.update', $product) }}">
                    @csrf
                    @method('PATCH')

                    <div class="admin-form-grid">
                        <label class="field span-2">
                            <span>Название</span>
                            <input name="name" value="{{ old('name', $product->name) }}" required>
                        </label>
                        <label class="field span-2">
                            <span>Slug</span>
                            <input name="slug" value="{{ old('slug', $product->slug) }}" required>
                        </label>
                        <label class="field span-2">
                            <span>Описание</span>
                            <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                        </label>
                        <label class="field">
                            <span>Цена, ₽</span>
                            <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required>
                        </label>
                        <label class="field">
                            <span>Остаток</span>
                            <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" required>
                        </label>
                        <label class="field span-2">
                            <span>Изображение (путь в storage)</span>
                            <input name="image" value="{{ old('image', $product->image) }}" placeholder="products/aero-tee-blue.svg">
                        </label>
                        <label class="field">
                            <span>Категория</span>
                            <select name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id) === (string) $category->id)>
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
                                    <option value="{{ $collection->id }}" @selected((string) old('collection_id', $product->collection_id) === (string) $collection->id)>
                                        {{ $collection->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <label class="field">
                            <span>Бренд</span>
                            <input name="brand" value="{{ old('brand', $product->brand) }}">
                        </label>
                        <label class="field">
                            <span>Размер</span>
                            <input name="size" value="{{ old('size', $product->size) }}">
                        </label>
                        <label class="field">
                            <span>Цвет</span>
                            <input name="color" value="{{ old('color', $product->color) }}">
                        </label>
                        <label class="field">
                            <span>Пол</span>
                            <select name="gender" required>
                                <option value="unisex" @selected(old('gender', $product->gender) === 'unisex')>Унисекс</option>
                                <option value="male" @selected(old('gender', $product->gender) === 'male')>Мужское</option>
                                <option value="female" @selected(old('gender', $product->gender) === 'female')>Женское</option>
                            </select>
                        </label>
                    </div>

                    <div class="hero-actions" style="margin-top: 0.8rem;">
                        <button class="btn btn-orange" type="submit">Сохранить</button>
                        <a class="btn btn-light" href="{{ route('admin.products.index') }}">Отмена</a>
                    </div>
                </form>
            </article>
        </div>
    </section>
@endsection

