<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - Tech Inventory</title>
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
        .categories { display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap; }
        .category { background: #1e293b; padding: 15px 25px; border-radius: 8px; text-decoration: none; color: #e2e8f0; font-weight: 500; border: 2px solid #334155; transition: all 0.3s ease; }
        .category:hover { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-color: transparent; transform: translateY(-2px); }
        .category.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-color: transparent; }
        .section-title { margin-bottom: 20px; color: #e2e8f0; font-weight: 600; font-size: 24px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .product-card { background: #1e293b; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3); transition: all 0.3s ease; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3); }
        .product-image { background: #334155; height: 200px; display: flex; align-items: center; justify-content: center; color: #94a3b8; }
        .product-info { padding: 20px; }
        .product-name { font-size: 18px; font-weight: 600; margin-bottom: 10px; color: #f1f5f9; }
        .product-description { color: #94a3b8; font-size: 14px; margin-bottom: 15px; line-height: 1.5; }
        .product-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }
        .product-price { font-size: 20px; font-weight: 700; color: #667eea; }
        .product-stock { font-size: 12px; padding: 5px 10px; border-radius: 4px; font-weight: 500; }
        .in-stock { background: rgba(102, 126, 234, 0.2); color: #667eea; }
        .low-stock { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .out-of-stock { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .featured { border: 3px solid #667eea; }
        .featured-badge { position: absolute; top: 10px; right: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
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