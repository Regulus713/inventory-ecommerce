<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - Tech Inventory</title>
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
        .categories { display: flex; gap: 12px; margin-bottom: 30px; flex-wrap: wrap; }
        .category { background: #f1f3f4; padding: 12px 20px; border-radius: 4px; text-decoration: none; color: #202124; font-weight: 500; border: none; transition: all 0.2s ease; }
        .category:hover { background: #e8eaed; }
        .category.active { background: #4285F4; color: white; }
        .section-title { margin-bottom: 20px; color: #202124; font-weight: 500; font-size: 22px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
        .product-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); transition: all 0.2s ease; border: 1px solid #e0e0e0; }
        .product-card:hover { box-shadow: 0 4px 6px rgba(0,0,0,0.15); transform: translateY(-2px); }
        .product-image { background: #f8f9fa; height: 200px; display: flex; align-items: center; justify-content: center; color: #5f6368; }
        .product-info { padding: 16px; }
        .product-name { font-size: 16px; font-weight: 500; margin-bottom: 8px; color: #202124; }
        .product-description { color: #5f6368; font-size: 14px; margin-bottom: 12px; line-height: 1.5; }
        .product-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 12px; }
        .product-price { font-size: 18px; font-weight: 500; color: #202124; }
        .product-stock { font-size: 12px; padding: 4px 8px; border-radius: 2px; font-weight: 500; }
        .in-stock { background: #e8f5e9; color: #137333; }
        .low-stock { background: #fff3e0; color: #f57c00; }
        .out-of-stock { background: #ffebee; color: #c62828; }
        .featured { border: 2px solid #4285F4; }
        .featured-badge { position: absolute; top: 8px; right: 8px; background: #4285F4; color: white; padding: 4px 8px; border-radius: 2px; font-size: 11px; font-weight: 500; }
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