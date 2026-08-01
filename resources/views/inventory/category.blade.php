<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - Tech Inventory</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            color: #1a1a2e;
            min-height: 100vh;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            color: #1a1a2e; 
            padding: 32px; 
            margin-bottom: 40px; 
            border-radius: 20px; 
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .header h1 { margin-bottom: 12px; font-weight: 800; font-size: 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .header p { opacity: 0.7; font-size: 16px; font-weight: 400; }
        .breadcrumb { margin-bottom: 24px; color: #666; font-size: 14px; font-weight: 500; }
        .breadcrumb a { color: #667eea; text-decoration: none; font-weight: 600; }
        .breadcrumb a:hover { text-decoration: underline; }
        .categories { display: flex; gap: 12px; margin-bottom: 40px; flex-wrap: wrap; }
        .category { 
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 14px 24px; 
            border-radius: 12px; 
            text-decoration: none; 
            color: #1a1a2e; 
            font-weight: 600; 
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .category:hover { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }
        .category.active { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }
        .section-title { margin-bottom: 24px; color: #1a1a2e; font-weight: 700; font-size: 28px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; }
        .product-card { 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .product-card:hover { 
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
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
            backdrop-filter: blur(10px);
            color: #667eea; 
            padding: 10px 20px; 
            border-radius: 12px; 
            text-decoration: none; 
            font-weight: 600; 
            border: 1px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .admin-link:hover { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }
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