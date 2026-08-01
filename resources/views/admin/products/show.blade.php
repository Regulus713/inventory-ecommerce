<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Admin</title>
    @vite(['resources/css/app.css'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #ffffff;
            color: #1a1a2e;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
        }
        .sidebar {
            width: 260px;
            background: #6366f1;
            padding: 24px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 32px rgba(99, 102, 241, 0.15);
            overflow-y: auto;
        }
        .content-wrapper {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        .container { max-width: 1000px; margin: 0 auto; }
        .main-content { width: 100%; }
        .sidebar h2 { 
            color: white; 
            font-weight: 800; 
            font-size: 20px; 
            margin-bottom: 24px; 
            display: flex; 
            align-items: center; 
            gap: 10px;
        }
        .nav-links { display: flex; flex-direction: column; gap: 8px; }
        .nav-link { 
            color: rgba(255, 255, 255, 0.8); 
            text-decoration: none; 
            padding: 12px 16px; 
            border-radius: 12px; 
            font-weight: 500; 
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link:hover, .nav-link.active { 
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .nav-link.active { 
            background: rgba(255, 255, 255, 0.25);
            font-weight: 600;
        }
        .main-content { flex: 1; }
        .header {
            background: #6366f1;
            color: white;
            padding: 32px;
            margin-bottom: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.15);
        }
        .header h1 { margin-bottom: 12px; font-weight: 800; font-size: 32px; }
        .header p { opacity: 0.9; font-size: 16px; font-weight: 400; }
        .detail-container { 
            background: white; 
            padding: 32px; 
            border-radius: 20px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }
        .detail-row { margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e9ecef; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: #1a1a2e; margin-bottom: 6px; font-size: 14px; }
        .detail-value { color: #666; font-size: 15px; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-active { background: #d1fae5; color: #0f5132; }
        .badge-inactive { background: #ffe3e3; color: #c92a2a; }
        .badge-featured { background: #ffedd5; color: #c85a17; }
        .stock-good { background: #d1fae5; color: #0f5132; }
        .stock-low { background: #ffedd5; color: #c85a17; }
        .stock-out { background: #ffe3e3; color: #c92a2a; }
        .btn { 
            padding: 12px 24px; 
            border: none; 
            border-radius: 12px; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-block; 
            font-weight: 600; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            font-size: 14px;
        }
        .btn-primary {
            background: #6366f1;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(99, 102, 241, 0.2);
        }
        .btn-secondary {
            background: #f8f9fa;
            color: #6366f1;
            border: 2px solid #e9ecef;
        }
        .btn-secondary:hover { 
            background: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>⚙️ Admin Panel</h2>
        <div class="nav-links">
            <a href="{{ route('inventory.index') }}" class="nav-link {{ request()->is('inventory.index') ? 'active' : '' }}">
                <span>🏠</span> Home
            </a>
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('categories.*') ? 'active' : '' }}">
                <span>📦</span> Categories
            </a>
            <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('products.*') ? 'active' : '' }}">
                <span>📊</span> Products
            </a>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="container">
        <div class="main-content">
            <div class="header">
                <h1>Product Details</h1>
                <p>View product information</p>
            </div>

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
    </div>
</body>
</html>