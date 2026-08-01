<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Tech Inventory</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #ffffff; color: #202124; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: #4285F4; color: white; padding: 24px; margin-bottom: 30px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { margin-bottom: 8px; font-weight: 500; font-size: 24px; }
        .header p { opacity: 0.9; font-size: 14px; }
        .breadcrumb { margin-bottom: 20px; color: #5f6368; font-size: 14px; }
        .breadcrumb a { color: #4285F4; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .product-detail { background: white; border-radius: 8px; padding: 24px; margin-bottom: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); border: 1px solid #e0e0e0; }
        .product-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .product-image { background: #f8f9fa; height: 400px; display: flex; align-items: center; justify-content: center; color: #5f6368; border-radius: 4px; }
        .product-info h1 { color: #202124; margin-bottom: 12px; font-weight: 500; font-size: 28px; }
        .product-price { font-size: 28px; font-weight: 500; color: #202124; margin-bottom: 16px; }
        .product-description { color: #5f6368; line-height: 1.6; margin-bottom: 16px; font-size: 14px; }
        .product-meta { margin-bottom: 16px; }
        .meta-item { margin-bottom: 8px; }
        .meta-label { font-weight: 500; color: #202124; }
        .stock-badge { display: inline-block; padding: 6px 12px; border-radius: 2px; font-weight: 500; font-size: 12px; }
        .in-stock { background: #e8f5e9; color: #137333; }
        .low-stock { background: #fff3e0; color: #f57c00; }
        .out-of-stock { background: #ffebee; color: #c62828; }
        .section-title { margin-bottom: 20px; color: #202124; font-weight: 500; font-size: 22px; }
        .related-products { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 16px; }
        .related-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); transition: all 0.2s ease; border: 1px solid #e0e0e0; }
        .related-card:hover { box-shadow: 0 4px 6px rgba(0,0,0,0.15); transform: translateY(-2px); }
        .related-image { background: #f8f9fa; height: 150px; display: flex; align-items: center; justify-content: center; color: #5f6368; }
        .related-info { padding: 16px; }
        .related-name { font-weight: 500; margin-bottom: 4px; color: #202124; font-size: 16px; }
        .related-price { color: #202124; font-weight: 500; font-size: 16px; }
        .admin-link { background: #f1f3f4; color: #4285F4; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: 500; border: none; transition: all 0.2s ease; }
        .admin-link:hover { background: #e8eaed; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Tech Inventory System</h1>
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