<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Inventory System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; margin-bottom: 30px; border-radius: 12px; }
        .header h1 { margin-bottom: 10px; font-weight: 700; }
        .header p { opacity: 0.9; }
        .categories { display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap; }
        .category { background: white; padding: 15px 25px; border-radius: 8px; text-decoration: none; color: #1e293b; font-weight: 500; border: 2px solid #e2e8f0; transition: all 0.3s ease; }
        .category:hover { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-color: transparent; color: white; transform: translateY(-2px); }
        .section-title { margin-bottom: 20px; color: #1e293b; font-weight: 600; font-size: 24px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .product-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); }
        .product-image { background: #f1f5f9; height: 200px; display: flex; align-items: center; justify-content: center; color: #64748b; }
        .product-info { padding: 20px; }
        .product-name { font-size: 18px; font-weight: 600; margin-bottom: 10px; color: #1e293b; }
        .product-description { color: #64748b; font-size: 14px; margin-bottom: 15px; line-height: 1.5; }
        .product-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }
        .product-price { font-size: 20px; font-weight: 700; color: #667eea; }
        .product-stock { font-size: 12px; padding: 5px 10px; border-radius: 4px; font-weight: 500; }
        .in-stock { background: #dbeafe; color: #1e40af; }
        .low-stock { background: #fef3c7; color: #92400e; }
        .out-of-stock { background: #fee2e2; color: #991b1b; }
        .featured { border: 3px solid #667eea; }
        .featured-badge { position: absolute; top: 10px; right: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .admin-link { background: rgba(255, 255, 255, 0.9); color: #667eea; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; border: 1px solid #667eea; transition: all 0.3s ease; }
        .admin-link:hover { background: #667eea; color: white; }
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
        <!-- Categories -->
        <h2 class="section-title">Categories</h2>
        <div class="categories">
            <a href="/" class="category">All Products</a>
            @foreach($categories as $category)
                <a href="{{ route('inventory.category', $category->slug) }}" class="category">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px; vertical-align: middle; margin-right: 8px;">
                    @endif
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Featured Products -->
        @if($featuredProducts->count() > 0)
            <h2 class="section-title">⭐ Featured Products</h2>
            <div class="products-grid">
                @foreach($featuredProducts as $product)
                    <div class="product-card featured" style="position: relative;">
                        <div class="featured-badge">FEATURED</div>
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ $product->name }}
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-description">{{ Str::limit($product->description, 80) }}</div>
                            <div class="product-meta">
                                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                                <div class="product-stock {{ $product->isInStock() ? 'in-stock' : ($product->isLowStock() ? 'low-stock' : 'out-of-stock') }}">
                                    {{ $product->quantity }} in stock
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- All Products -->
        <h2 class="section-title">All Products</h2>
        <div class="products-grid">
            @foreach($allProducts as $product)
                <div class="product-card">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ $product->name }}
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-description">{{ Str::limit($product->description, 80) }}</div>
                        <div class="product-meta">
                            <div class="product-price">${{ number_format($product->price, 2) }}</div>
                            <div class="product-stock {{ $product->isInStock() ? 'in-stock' : ($product->isLowStock() ? 'low-stock' : 'out-of-stock') }}">
                                {{ $product->quantity }} in stock
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($allProducts->hasPages())
            <div style="margin-top: 30px; text-align: center;">
                {{ $allProducts->links() }}
            </div>
        @endif
    </div>
</body>
</html>