@extends('layouts.app')

@section('title', $category->name . ' - Tech Inventory')

@section('content')
    @php($currentCategory = $category->slug)

    <header class="app-header">
        <h1>Tech Inventory System</h1>
        <p>Manage your technology products efficiently</p>
    </header>

    <!-- Search -->
    <div class="search-bar">
        @include('partials.search')
    </div>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="{{ route('inventory.index') }}">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span>{{ $category->name }}</span>
    </nav>

    <!-- Categories -->
    <div class="category-list">
        <a href="{{ route('inventory.index') }}" class="category-chip">All Products</a>
        @foreach($categories as $cat)
            <a href="{{ route('inventory.category', $cat->slug) }}" class="category-chip {{ $cat->id === $category->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Category Info -->
    <h2 class="section-title">{{ $category->name }}</h2>
    @if($category->description)
        <p class="text-center mb-8" style="color: var(--color-text-muted);">{{ $category->description }}</p>
    @endif

    <!-- Products -->
    @if($products->count() > 0)
        <div class="products-grid">
            @foreach($products as $product)
                <div class="card {{ $product->is_featured ? 'card-featured' : '' }}">
                    @if($product->is_featured)
                        <span class="card-badge">Featured</span>
                    @endif
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

        @if($products->hasPages())
            <div class="pagination">
                {{ $products->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; color: var(--color-primary-400);"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <p>No products found in this category.</p>
        </div>
    @endif
@endsection
