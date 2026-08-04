@extends('layouts.admin')

@section('title', 'Product Management - Admin')

@section('content')
    <header class="app-header">
        <h1>Product Management</h1>
        <p>Manage your tech products</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div style="display: flex; gap: 0.75rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add New Product</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Manage Categories</a>
        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Back to Inventory</a>
    </div>

    <div class="data-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 44px; height: 44px; object-fit: cover; border-radius: 8px;">
                                @endif
                                <span style="font-weight: 600; color: var(--color-text-main);">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td style="font-weight: 700; color: var(--color-primary-600);">${{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge {{ $product->isInStock() ? 'badge-success' : ($product->isLowStock() ? 'badge-warning' : 'badge-danger') }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                @if($product->is_featured)
                                    <span class="badge badge-warning">Featured</span>
                                @endif
                                <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="pagination">
            {{ $products->links() }}
        </div>
    @endif

    @if($products->count() === 0)
        <div class="empty-state">
            No products found. <a href="{{ route('products.create') }}">Create one</a>
        </div>
    @endif
@endsection
