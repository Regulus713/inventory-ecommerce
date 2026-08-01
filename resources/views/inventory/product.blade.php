<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Tech Inventory</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0f172a; color: #e2e8f0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; margin-bottom: 30px; border-radius: 12px; }
        .header h1 { margin-bottom: 10px; font-weight: 700; }
        .header p { opacity: 0.9; }
        .breadcrumb { margin-bottom: 20px; color: #94a3b8; }
        .breadcrumb a { color: #667eea; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .product-detail { background: #1e293b; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3); }
        .product-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .product-image { background: #334155; height: 400px; display: flex; align-items: center; justify-content: center; color: #94a3b8; border-radius: 8px; }
        .product-info h1 { color: #f1f5f9; margin-bottom: 15px; font-weight: 700; }
        .product-price { font-size: 32px; font-weight: 700; color: #667eea; margin-bottom: 20px; }
        .product-description { color: #94a3b8; line-height: 1.6; margin-bottom: 20px; }
        .product-meta { margin-bottom: 20px; }
        .meta-item { margin-bottom: 10px; }
        .meta-label { font-weight: 600; color: #f1f5f9; }
        .stock-badge { display: inline-block; padding: 8px 16px; border-radius: 4px; font-weight: 600; }
        .in-stock { background: rgba(102, 126, 234, 0.2); color: #667eea; }
        .low-stock { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .out-of-stock { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .section-title { margin-bottom: 20px; color: #e2e8f0; font-weight: 600; font-size: 24px; }
        .related-products { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .related-card { background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3); transition: all 0.3s ease; }
        .related-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3); }
        .related-image { background: #334155; height: 150px; display: flex; align-items: center; justify-content: center; color: #94a3b8; }
        .related-info { padding: 15px; }
        .related-name { font-weight: 600; margin-bottom: 5px; color: #f1f5f9; }
        .related-price { color: #667eea; font-weight: 700; }
        .admin-link { background: rgba(255, 255, 255, 0.1); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; border: 1px solid rgba(255, 255, 255, 0.2); transition: all 0.3s ease; }
        .admin-link:hover { background: rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>🖥️ Tech Inventory System</h1>
            <p>Manage your technology products efficiently</p>
            <div style="margin-top: 15px;">
                <a href="{{ route('categories.index') }}" class="admin-link">Manage Categories</a>
                <a href="{{ route('products.index') }}" class="admin-link" style="margin-left: 10px;">Manage Products</a>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('inventory.index') }}">Home</a> > 
            <a href="{{ route('inventory.category', $product->category->slug) }}">{{ $product->category->name }}</a> > 
            {{ $product->name }}
        </div>

        <!-- Product Detail -->
        <div class="product-detail">
            <div class="product-grid">
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ $product->name }}
                    @endif
                </div>
                <div class="product-info">
                    <h1>{{ $product->name }}</h1>
                    <div class="product-price">${{ number_format($product->price, 2) }}</div>
                    
                    <div class="product-meta">
                        <div class="meta-item">
                            <span class="meta-label">Category:</span> {{ $product->category->name }}
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">SKU:</span> {{ $product->sku }}
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Manufacturer:</span> {{ $product->manufacturer }}
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Model:</span> {{ $product->model }}
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Warranty:</span> {{ $product->warranty }}
                        </div>
                        <div class="meta-item">
                            <span class="stock-badge {{ $product->isInStock() ? 'in-stock' : ($product->isLowStock() ? 'low-stock' : 'out-of-stock') }}">
                                {{ $product->quantity }} in stock
                            </span>
                        </div>
                    </div>

                    <div class="product-description">
                        <strong>Description:</strong><br>
                        {{ $product->description }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <h2 class="section-title">Related Products</h2>
            <div class="related-products">
                @foreach($relatedProducts as $related)
                    <div class="related-card">
                        <div class="related-image">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ $related->name }}
                            @endif
                        </div>
                        <div class="related-info">
                            <div class="related-name">{{ $related->name }}</div>
                            <div class="related-price">${{ number_format($related->price, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>