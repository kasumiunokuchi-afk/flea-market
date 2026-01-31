<div class="product-card">
    <a href="/item/{{ $product->id }}">
        @if(Str::startsWith($product->image_path, 'http'))
            <img src="{{ $product->image_path }}">
        @else
            <img src="{{ asset('storage/' . $product->image_path) }}">
        @endif
        <div class="product-card__text">
            <h3>{{ $product->name }}</h3>
            <span class="product-card__sold">
                @if($product->purchase)
                    Sold
                @endif
            </span>
        </div>
    </a>
</div>