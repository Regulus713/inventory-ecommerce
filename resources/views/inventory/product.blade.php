<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Tech Inventory</title>
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
        .container { max-width: 1000px; margin: 0 auto; }
        .main-content { width: 100%; }
        .header { 
            background: #6366f1;
            color: white; 
            padding: 32px; 
            margin-bottom: 40px; 
            border-radius: 20px; 
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
            text-align: center;
        }
        .header h1 { margin-bottom: 12px; font-weight: 800; font-size: 32px; }
        .header p { opacity: 0.9; font-size: 16px; font-weight: 400; }
        .breadcrumb { margin-bottom: 24px; color: #666; font-size: 14px; font-weight: 500; }
        .breadcrumb a { color: #6366f1; text-decoration: none; font-weight: 600; }
        .breadcrumb a:hover { text-decoration: underline; }
        .product-detail { 
            background: white; 
            border-radius: 20px; 
            padding: 32px; 
            margin-bottom: 40px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }
        .product-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; justify-items: center; }
        .product-image { 
            background: #f3f4f6;
            height: 450px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: #6366f1;
            font-weight: 600;
            border-radius: 16px;
        }
        .product-info h1 { color: #1a1a2e; margin-bottom: 16px; font-weight: 800; font-size: 36px; }
        .product-price { font-size: 36px; font-weight: 800; color: #6366f1; margin-bottom: 20px; }
        .product-description { color: #666; line-height: 1.7; margin-bottom: 20px; font-size: 16px; }
        .product-meta { margin-bottom: 20px; }
        .meta-item { margin-bottom: 12px; }
        .meta-label { font-weight: 600; color: #1a1a2e; }
        .stock-badge { display: inline-block; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 13px; }
        .in-stock { background: #d1fae5; color: #0f5132; }
        .low-stock { background: #ffedd5; color: #c85a17; }
        .out-of-stock { background: #ffe3e3; color: #c92a2a; }
        .section-title { margin-bottom: 24px; color: #1a1a2e; font-weight: 700; font-size: 28px; }
        .related-products { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
        .related-card { 
            background: white; 
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e9ecef;
        }
        .related-card:hover { 
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }
        .related-image { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 180px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: #667eea;
            font-weight: 600;
        }
        .related-info { padding: 20px; }
        .related-name { font-weight: 700; margin-bottom: 8px; color: #1a1a2e; font-size: 16px; }
        .related-price { color: #6366f1; font-weight: 800; font-size: 18px; }
        .admin-link { 
            background: rgba(255, 255, 255, 0.9);
            color: #6366f1; 
            padding: 10px 20px; 
            border-radius: 12px; 
            text-decoration: none; 
            font-weight: 600; 
            border: 2px solid rgba(99, 102, 241, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .admin-link:hover { 
            background: #6366f1;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
            border-color: transparent;
        }
    </style>
</head>
<body>
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
    <div class="content-wrapper">
        <div class="container">
        <div class="main-content">
            <div class="header">
                <h1>Tech Inventory System</h1>
                <p>Manage your technology products efficiently</p>
            </div>

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
    </div>
</body>
</html>