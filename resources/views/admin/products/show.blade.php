<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #ffffff; color: #202124; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .header { background: #4285F4; color: white; padding: 24px; margin-bottom: 30px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { margin-bottom: 8px; font-weight: 500; font-size: 24px; }
        .header p { opacity: 0.9; font-size: 14px; }
        .detail-container { background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); border: 1px solid #e0e0e0; }
        .detail-row { margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #e0e0e0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 500; color: #202124; margin-bottom: 4px; font-size: 14px; }
        .detail-value { color: #5f6368; font-size: 14px; }
        .badge { padding: 4px 8px; border-radius: 2px; font-size: 12px; font-weight: 500; }
        .badge-active { background: #e8f5e9; color: #137333; }
        .badge-inactive { background: #ffebee; color: #c62828; }
        .badge-featured { background: #fff3e0; color: #f57c00; }
        .stock-good { background: #e8f5e9; color: #137333; }
        .stock-low { background: #fff3e0; color: #f57c00; }
        .stock-out { background: #ffebee; color: #c62828; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: 500; transition: all 0.2s ease; font-size: 14px; }
        .btn-primary { background: #4285F4; color: white; }
        .btn-primary:hover { background: #3367D6; }
        .btn-secondary { background: #f1f3f4; color: #202124; }
        .btn-secondary:hover { background: #e8eaed; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Product Details</h1>
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