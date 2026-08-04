@extends('layouts.app')

@section('title', 'Tech Inventory System')

@section('content')
    <header class="app-header">
        <h1>Tech Inventory System</h1>
        <p>Manage your technology products efficiently</p>
    </header>

    <!-- Categories -->
    <h2 class="section-title">Categories</h2>
    <div class="category-list">
        <a href="{{ route('inventory.index') }}" class="category-chip active">All Products</a>
        @foreach($categories as $category)
            <a href="{{ route('inventory.category', $category->slug) }}" class="category-chip">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                @endif
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
        <h2 class="section-title">Featured Products</h2>
        <div class="products-grid">
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

    <!-- All Products -->
    <h2 class="section-title" style="margin-top: 2.5rem;">All Products</h2>
    <div class="products-grid">
        @foreach($allProducts as $product)
            <div class="card">
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

    @if($allProducts->hasPages())
        <div class="pagination">
            {{ $allProducts->links() }}
        </div>
    @endif
@endsection
