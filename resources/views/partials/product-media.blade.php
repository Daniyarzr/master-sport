@php
    $href = $link ?? route('catalog.show', $product);
@endphp

<a class="product-media" href="{{ $href }}">
    @if ($product->image)
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
    @else
        <span class="product-media-placeholder">Нет фото</span>
    @endif
</a>
