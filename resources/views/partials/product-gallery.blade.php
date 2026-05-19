@if ($product->image)
    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
@else
    <span class="product-media-placeholder product-media-placeholder-lg">Нет фото</span>
@endif
