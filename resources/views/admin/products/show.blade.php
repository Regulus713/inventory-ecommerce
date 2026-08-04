@extends('layouts.admin')

@section('title', 'Product Details - Admin')

@section('content')
    <header class="app-header">
        <h1>Product Details</h1>
        <p>View product information</p>
    </header>

    <div class="form-card" style="max-width: 800px;">
        @if($product->image)
            <div style="margin-bottom: 1.5rem;">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 300px; border-radius: 12px;">
            </div>
        @endif

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">ID</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $product->id }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Name</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $product->name }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Slug</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $product->slug }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">SKU</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $product->sku }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Barcode</div>
            <div style="color: var(--color-text-muted);">{{ $product->barcode ?: 'N/A' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Category</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $product->category->name }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Description</div>
            <div style="color: var(--color-text-muted); line-height: 1.6;">{{ $product->description ?: 'N/A' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Price</div>
            <div style="color: var(--color-primary-600); font-weight: 700; font-size: 1.25rem;">${{ number_format($product->price, 2) }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Compare Price</div>
            <div style="color: var(--color-text-muted);">{{ $product->compare_price ? '$' . number_format($product->compare_price, 2) : 'N/A' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Stock</div>
            <span class="badge {{ $product->isInStock() ? 'badge-success' : ($product->isLowStock() ? 'badge-warning' : 'badge-danger') }}">
                {{ $product->quantity }} in stock (Low stock threshold: {{ $product->low_stock_threshold }})
            </span>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Manufacturer</div>
            <div style="color: var(--color-text-muted);">{{ $product->manufacturer ?: 'N/A' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Model</div>
            <div style="color: var(--color-text-muted);">{{ $product->model ?: 'N/A' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Warranty</div>
            <div style="color: var(--color-text-muted);">{{ $product->warranty ?: 'N/A' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Weight</div>
            <div style="color: var(--color-text-muted);">{{ $product->weight ? $product->weight . ' kg' : 'N/A' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Dimensions</div>
            <div style="color: var(--color-text-muted);">{{ $product->dimensions ?: 'N/A' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Status</div>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                @if($product->is_featured)
                    <span class="badge badge-warning">Featured</span>
                @endif
                <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                </span>
                @if($product->is_digital)
                    <span class="badge badge-info">Digital</span>
                @endif
            </div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Specifications</div>
            <div style="color: var(--color-text-muted);">
                @if($product->specifications->count() > 0)
                    <ul style="list-style-position: inside; line-height: 1.7;">
                        @foreach($product->specifications as $spec)
                            <li>{{ $spec->spec_key }}: {{ $spec->spec_value }}</li>
                        @endforeach
                    </ul>
                @else
                    N/A
                @endif
            </div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Created At</div>
            <div style="color: var(--color-text-muted);">{{ $product->created_at->format('Y-m-d H:i:s') }}</div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Updated At</div>
            <div style="color: var(--color-text-muted);">{{ $product->updated_at->format('Y-m-d H:i:s') }}</div>
        </div>

        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit Product</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>
@endsection
