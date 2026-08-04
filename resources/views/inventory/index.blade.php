@extends('layouts.app')

@section('title', 'Tech Inventory System')

@section('content')
    @php($currentCategory = '')

    <header class="app-header">
        <h1>Tech Inventory System</h1>
        <p>Manage your technology products efficiently</p>
    </header>

    <!-- Featured Products -->
    <div id="featured-products-section">
        @if($featuredProducts->count() > 0)
            <h2 class="section-title">Featured Products</h2>
            <div class="products-grid" id="featured-products-grid">
                @foreach($featuredProducts as $product)
                    <div class="card card-featured">
                        <span class="card-badge">Featured</span>
                        <a href="{{ route('inventory.product', $product->slug) }}" class="card-link">
                            <div class="card-image">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    {{ $product->name }}
                                @endif
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">{{ $product->name }}</h3>
                                <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
                                <div class="card-meta">
                                    <span class="card-price">${{ number_format($product->price, 2) }}</span>
                                    <span class="badge {{ $product->isInStock() ? 'badge-success' : ($product->isLowStock() ? 'badge-warning' : 'badge-danger') }}">
                                        {{ $product->quantity }} in stock
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- All Products -->
    <h2 class="section-title" style="margin-top: 2.5rem;" id="all-products-title">All Products</h2>
    <div class="products-grid" id="all-products-grid">
        @foreach($allProducts as $product)
            <div class="card" data-product-id="{{ $product->id }}">
                <a href="{{ route('inventory.product', $product->slug) }}" class="card-link">
                    <div class="card-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            {{ $product->name }}
                        @endif
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $product->name }}</h3>
                        <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
                        <div class="card-meta">
                            <span class="card-price">${{ number_format($product->price, 2) }}</span>
                            <span class="badge {{ $product->isInStock() ? 'badge-success' : ($product->isLowStock() ? 'badge-warning' : 'badge-danger') }}">
                                {{ $product->quantity }} in stock
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="empty-state" id="no-products-message" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; color: var(--color-primary-400);"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <p>No products found matching your search.</p>
    </div>

    <div id="all-products-pagination">
        @if($allProducts->hasPages())
            <div class="pagination">
                {{ $allProducts->links() }}
            </div>
        @endif
    </div>

    <template id="product-card-template">
        <div class="card">
            <a href="" class="card-link product-card-link">
                <div class="card-image">
                    <img src="" alt="" class="product-card-img" style="display: none;">
                    <span class="product-card-img-placeholder"></span>
                </div>
                <div class="card-body">
                    <h3 class="card-title product-card-name"></h3>
                    <p class="card-text product-card-description"></p>
                    <div class="card-meta">
                        <span class="card-price product-card-price"></span>
                        <span class="badge product-card-stock"></span>
                    </div>
                </div>
            </a>
        </div>
    </template>
@endsection
