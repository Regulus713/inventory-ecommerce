<div class="product-list-item" data-product-id="{{ $product->id }}">
    <div class="product-list-image">
        <a href="{{ route('inventory.product', $product->slug) }}">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <span class="product-list-placeholder">{{ $product->name }}</span>
            @endif
        </a>
    </div>
    <div class="product-list-info">
        <div class="product-list-main">
            <a href="{{ route('inventory.product', $product->slug) }}" class="product-list-name">{{ $product->name }}</a>
            <span class="product-list-category">{{ $product->category->name }}</span>
            <p class="product-list-description">{{ Str::limit($product->description, 120) }}</p>
        </div>
        <div class="product-list-meta">
            <span class="product-list-price">${{ number_format($product->price, 2) }}</span>
            <span class="badge {{ $product->isInStock() ? 'badge-success' : ($product->isLowStock() ? 'badge-warning' : 'badge-danger') }}">
                {{ $product->quantity }} in stock
            </span>
            <span class="product-list-sku">SKU: {{ $product->sku }}</span>
        </div>
    </div>
    <div class="product-list-actions">
        @if($product->quantity > 0)
            <form action="{{ route('cart.add', $product->slug) }}" method="POST" class="add-to-cart-form">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    Add to Cart
                </button>
            </form>
        @else
            <span class="badge badge-danger">Out of Stock</span>
        @endif
        <a href="{{ route('inventory.product', $product->slug) }}" class="btn btn-secondary btn-sm">View</a>
    </div>
</div>
