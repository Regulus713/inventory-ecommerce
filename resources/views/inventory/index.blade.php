<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Inventory System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: #ffffff;
            color: #1a1a2e;
            min-height: 100vh;
        }
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; display: flex; gap: 20px; }
        .sidebar { 
            width: 260px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 24px; 
            position: sticky; 
            top: 20px; 
            height: fit-content;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
            flex-shrink: 0;
        }
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            color: white; 
            padding: 32px; 
            margin-bottom: 40px; 
            border-radius: 20px; 
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
        }
        .header h1 { margin-bottom: 12px; font-weight: 800; font-size: 32px; }
        .header p { opacity: 0.9; font-size: 16px; font-weight: 400; }
        .categories { display: flex; gap: 12px; margin-bottom: 40px; flex-wrap: wrap; }
        .category { 
            background: #f8f9fa;
            padding: 14px 24px; 
            border-radius: 12px; 
            text-decoration: none; 
            color: #1a1a2e; 
            font-weight: 600; 
            border: 2px solid #e9ecef;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .category:hover { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
            border-color: transparent;
        }
        .category.active { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
            border-color: transparent;
        }
        .section-title { margin-bottom: 24px; color: #1a1a2e; font-weight: 700; font-size: 28px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; }
        .product-card { 
            background: white; 
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e9ecef;
        }
        .product-card:hover { 
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }
        .product-image { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 220px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: #667eea;
            font-weight: 600;
        }
        .product-info { padding: 24px; }
        .product-name { font-size: 18px; font-weight: 700; margin-bottom: 12px; color: #1a1a2e; }
        .product-description { color: #666; font-size: 14px; margin-bottom: 16px; line-height: 1.6; }
        .product-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
        .product-price { font-size: 22px; font-weight: 800; color: #667eea; }
        .product-stock { font-size: 12px; padding: 6px 12px; border-radius: 20px; font-weight: 600; }
        .in-stock { background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%); color: #0f5132; }
        .low-stock { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #c85a17; }
        .out-of-stock { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: #c92a2a; }
        .featured { border: 2px solid #667eea; }
        .featured-badge { 
            position: absolute; 
            top: 12px; 
            right: 12px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 6px 12px; 
            border-radius: 20px; 
            font-size: 11px; 
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .admin-link { 
            background: rgba(255, 255, 255, 0.9);
            color: #667eea; 
            padding: 10px 20px; 
            border-radius: 12px; 
            text-decoration: none; 
            font-weight: 600; 
            border: 2px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .admin-link:hover { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
            border-color: transparent;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>🖥️ Tech Inventory</h2>
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
        <div class="main-content">
            <div class="header">
                <h1>Tech Inventory System</h1>
                <p>Manage your technology products efficiently</p>
            </div>

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
    </div>
</body>
</html>