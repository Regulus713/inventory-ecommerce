<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .header { background: #1e3a8a; color: white; padding: 20px; margin-bottom: 30px; }
        .detail-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .detail-row { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e5e7eb; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: bold; color: #1f2937; margin-bottom: 5px; }
        .detail-value { color: #6b7280; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .badge-active { background: #d1fae5; color: #065f46; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        .badge-featured { background: #fef3c7; color: #92400e; }
        .stock-good { background: #d1fae5; color: #065f46; }
        .stock-low { background: #fef3c7; color: #92400e; }
        .stock-out { background: #fee2e2; color: #991b1b; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #1e3a8a; color: white; }
        .btn-primary:hover { background: #1e40af; }
        .btn-secondary { background: #6b7280; color: white; }
        .btn-secondary:hover { background: #4b5563; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>🖥️ Product Details</h1>
            <p>View product information</p>
        </div>
    </div>

    <div class="container">
        <div class="detail-container">
            <div class="detail-row">
                <div class="detail-label">ID</div>
                <div class="detail-value">{{ $product->id }}</div>
            </div>

            @if($product->image)
                <div class="detail-row">
                    <div class="detail-label">Image</div>
                    <div class="detail-value">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 300px; border-radius: 4px;">
                    </div>
                </div>
            @endif

            <div class="detail-row">
                <div class="detail-label">Name</div>
                <div class="detail-value">{{ $product->name }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Slug</div>
                <div class="detail-value">{{ $product->slug }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">SKU</div>
                <div class="detail-value">{{ $product->sku }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Barcode</div>
                <div class="detail-value">{{ $product->barcode ?: 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Category</div>
                <div class="detail-value">{{ $product->category->name }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Description</div>
                <div class="detail-value">{{ $product->description ?: 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Price</div>
                <div class="detail-value">${{ number_format($product->price, 2) }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Compare Price</div>
                <div class="detail-value">{{ $product->compare_price ? '$' . number_format($product->compare_price, 2) : 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Stock</div>
                <div class="detail-value">
                    <span class="badge {{ $product->isInStock() ? 'stock-good' : ($product->isLowStock() ? 'stock-low' : 'stock-out') }}">
                        {{ $product->quantity }} in stock (Low stock threshold: {{ $product->low_stock_threshold }})
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Manufacturer</div>
                <div class="detail-value">{{ $product->manufacturer ?: 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Model</div>
                <div class="detail-value">{{ $product->model ?: 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Warranty</div>
                <div class="detail-value">{{ $product->warranty ?: 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Weight</div>
                <div class="detail-value">{{ $product->weight ? $product->weight . ' kg' : 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Dimensions</div>
                <div class="detail-value">{{ $product->dimensions ?: 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    @if($product->is_featured)
                        <span class="badge badge-featured">Featured</span>
                    @endif
                    <span class="badge {{ $product->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($product->is_digital)
                        <span class="badge badge-featured">Digital</span>
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Specifications</div>
                <div class="detail-value">
                    @if($product->specifications->count() > 0)
                        <ul style="list-style-position: inside;">
                            @foreach($product->specifications as $spec)
                                <li>{{ $spec->spec_key }}: {{ $spec->spec_value }}</li>
                            @endforeach
                        </ul>
                    @else
                        N/A
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Created At</div>
                <div class="detail-value">{{ $product->created_at->format('Y-m-d H:i:s') }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Updated At</div>
                <div class="detail-value">{{ $product->updated_at->format('Y-m-d H:i:s') }}</div>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit Product</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </div>
</body>
</html>