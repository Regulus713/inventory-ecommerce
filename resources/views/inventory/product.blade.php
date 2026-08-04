@extends('layouts.app')

@section('title', $product->name . ' - Tech Inventory')

@section('content')
    <header class="app-header">
        <h1>Tech Inventory System</h1>
        <p>Manage your technology products efficiently</p>
    </header>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="{{ route('inventory.index') }}">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('inventory.category', $product->category->slug) }}">{{ $product->category->name }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span>{{ $product->name }}</span>
    </nav>

    <!-- Product Detail -->
    <div class="product-detail">
        <div class="product-detail-grid">
            <div class="product-detail-image">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    {{ $product->name }}
                @endif
            </div>
            <div class="product-detail-info">
                <h1>{{ $product->name }}</h1>
                <div class="product-detail-price">${{ number_format($product->price, 2) }}</div>

                <div class="product-detail-meta">
                    <div class="meta-row">
                        <span class="meta-label">Category</span>
                        <span class="meta-value">{{ $product->category->name }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">SKU</span>
                        <span class="meta-value">{{ $product->sku }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Manufacturer</span>
                        <span class="meta-value">{{ $product->manufacturer }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Model</span>
                        <span class="meta-value">{{ $product->model }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Warranty</span>
                        <span class="meta-value">{{ $product->warranty }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Stock</span>
                        <span class="badge {{ $product->isInStock() ? 'badge-success' : ($product->isLowStock() ? 'badge-warning' : 'badge-danger') }}">
                            {{ $product->quantity }} in stock
                        </span>
                    </div>
                </div>

                <div class="product-detail-description">
                    <strong>Description</strong>
                    <p style="margin-top: 0.5rem;">{{ $product->description }}</p>
                </div>

                @if($product->quantity > 0)
                    <form action="{{ route('cart.add', $product->slug) }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <div class="form-group flex items-center gap-3" style="align-items: flex-end;">
                            <div style="flex: 1;">
                                <label for="quantity">Quantity</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="form-input" required>
                            </div>
                            <button type="submit" class="btn btn-primary" style="padding: 0.85rem 1.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                Add to Cart
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-error">This product is currently out of stock.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <h2 class="section-title">Related Products</h2>
        <div class="related-products-grid">
            @foreach($relatedProducts as $related)
                <div class="card">
                    <a href="{{ route('inventory.product', $related->slug) }}" class="card-link">
                        <div class="card-image" style="height: 180px;">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}">
                            @else
                                {{ $related->name }}
                            @endif
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">{{ $related->name }}</h3>
                            <div class="card-meta" style="margin-top: auto;">
                                <span class="card-price">${{ number_format($related->price, 2) }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
