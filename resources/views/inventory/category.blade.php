<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - Tech Inventory</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: #1e3a8a; color: white; padding: 20px; margin-bottom: 30px; }
        .breadcrumb { margin-bottom: 20px; color: #6b7280; }
        .breadcrumb a { color: #1e3a8a; text-decoration: none; }
        .categories { display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap; }
        .category { background: white; padding: 15px 25px; border-radius: 8px; text-decoration: none; color: #1e3a8a; font-weight: bold; border: 2px solid #1e3a8a; transition: all 0.3s; }
        .category:hover { background: #1e3a8a; color: white; }
        .category.active { background: #1e3a8a; color: white; }
        .section-title { margin-bottom: 20px; color: #1e3a8a; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .product-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .product-card:hover { transform: translateY(-5px); }
        .product-image { background: #e5e7eb; height: 200px; display: flex; align-items: center; justify-content: center; color: #6b7280; }
        .product-info { padding: 15px; }
        .product-name { font-size: 18px; font-weight: bold; margin-bottom: 10px; color: #1f2937; }
        .product-description { color: #6b7280; font-size: 14px; margin-bottom: 10px; }
        .product-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
        .product-price { font-size: 20px; font-weight: bold; color: #059669; }
        .product-stock { font-size: 12px; padding: 5px 10px; border-radius: 4px; }
        .in-stock { background: #d1fae5; color: #065f46; }
        .low-stock { background: #fef3c7; color: #92400e; }
        .out-of-stock { background: #fee2e2; color: #991b1b; }
        .featured { border: 3px solid #f59e0b; }
        .featured-badge { position: absolute; top: 10px; right: 10px; background: #f59e0b; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
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
            <a href="{{ route('inventory.index') }}">Home</a> > {{ $category->name }}
        </div>

        <!-- Categories -->
        <div class="categories">
            <a href="{{ route('inventory.index') }}" class="category">All Products</a>
            @foreach($categories as $cat)
                <a href="{{ route('inventory.category', $cat->slug) }}" class="category {{ $cat->id === $category->id ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <!-- Category Info -->
        <h2 class="section-title">{{ $category->name }}</h2>
        @if($category->description)
            <p style="margin-bottom: 20px; color: #6b7280;">{{ $category->description }}</p>
        @endif

        <!-- Products -->
        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card {{ $product->is_featured ? 'featured' : '' }}" style="position: relative;">
                        @if($product->is_featured)
                            <div class="featured-badge">FEATURED</div>
                        @endif
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

            @if($products->hasPages())
                <div style="margin-top: 30px; text-align: center;">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <p style="text-align: center; color: #6b7280; padding: 40px;">No products found in this category.</p>
        @endif
    </div>
</body>
</html>