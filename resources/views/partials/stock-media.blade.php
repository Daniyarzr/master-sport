@php
    $href = $link ?? route('stocks.show', $stock);
@endphp

<a class="stock-card-media" href="{{ $href }}">
    @if ($stock->image_path)
        <img src="{{ asset($stock->image_path) }}" alt="{{ $stock->title }}">
    @else
        <span class="product-media-placeholder">Нет фото</span>
    @endif
    @isset($badge)
        {!! $badge !!}
    @endisset
</a>
