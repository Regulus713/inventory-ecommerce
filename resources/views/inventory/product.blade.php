<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Tech Inventory</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: #1e3a8a; color: white; padding: 20px; margin-bottom: 30px; }
        .breadcrumb { margin-bottom: 20px; color: #6b7280; }
        .breadcrumb a { color: #1e3a8a; text-decoration: none; }
        .product-detail { background: white; border-radius: 8px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .product-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .product-image { background: #e5e7eb; height: 400px; display: flex; align-items: center; justify-content: center; color: #6b7280; border-radius: 8px; }
        .product-info h1 { color: #1f2937; margin-bottom: 15px; }
        .product-price { font-size: 32px; font-weight: bold; color: #059669; margin-bottom: 20px; }
        .product-description { color: #6b7280; line-height: 1.6; margin-bottom: 20px; }
        .product-meta { margin-bottom: 20px; }
        .meta-item { margin-bottom: 10px; }
        .meta-label { font-weight: bold; color: #1f2937; }
        .stock-badge { display: inline-block; padding: 8px 16px; border-radius: 4px; font-weight: bold; }
        .in-stock { background: #d1fae5; color: #065f46; }
        .low-stock { background: #fef3c7; color: #92400e; }
        .out-of-stock { background: #fee2e2; color: #991b1b; }
        .section-title { margin-bottom: 20px; color: #1e3a8a; }
        .related-products { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .related-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .related-image { background: #e5e7eb; height: 150px; display: flex; align-items: center; justify-content: center; color: #6b7280; }
        .related-info { padding: 15px; }
        .related-name { font-weight: bold; margin-bottom: 5px; color: #1f2937; }
        .related-price { color: #059669; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>🖥️ Tech Inventory System</h1>
            <p>Manage your technology products efficiently</p>
            <div style="margin-top: 15px;">
                <a href="{{ route('categories.index') }}" style="background: white; color: #1e3a8a; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: bold;">Manage Categories</a>
                <a href="{{ route('products.index') }}" style="background: white; color: #1e3a8a; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: bold; margin-left: 10px;">Manage Products</a>
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