<!-- resources/views/components/product-card.blade.php -->
<div class="product-card">
    <a href="/item/{{ $product->id }}">
        @if(Str::startsWith($product->image_path, 'http'))
            <img src="{{ $product->image_path }}">
        @else
            <img src="{{ asset('storage/' . $product->image_path) }}">
        @endif
        <div class="product-card__text">
            <h3>{{ $product->name }}</h3>
        </div>
    </a>
</div>