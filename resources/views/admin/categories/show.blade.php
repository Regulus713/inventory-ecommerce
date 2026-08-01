<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details - Admin</title>
    @vite(['resources/css/app.css'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #ffffff;
            color: #1a1a2e;
            min-height: 100vh;
            display: flex;
        }
        .sidebar { 
            width: 260px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 24px; 
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 32px rgba(102, 126, 234, 0.3);
            overflow-y: auto;
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
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; flex: 1; margin-left: 260px; }
        .main-content { }
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
        .detail-container { 
            background: white; 
            padding: 32px; 
            border-radius: 20px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }
        .detail-row { margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e9ecef; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: #1a1a2e; margin-bottom: 6px; font-size: 14px; }
        .detail-value { color: #666; font-size: 15px; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-active { background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%); color: #0f5132; }
        .badge-inactive { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: #c92a2a; }
        .btn { 
            padding: 12px 24px; 
            border: none; 
            border-radius: 12px; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-block; 
            font-weight: 600; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            font-size: 14px;
        }
        .btn-primary { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .btn-primary:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary { 
            background: #f8f9fa;
            color: #667eea;
            border: 2px solid #e9ecef;
        }
        .btn-secondary:hover { 
            background: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>⚙️ Admin Panel</h2>
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
    <div class="container">
        <div class="main-content">
            <div class="header">
                <h1>Category Details</h1>
                <p>View category information</p>
            </div>

            <div class="detail-container">
                <div class="detail-row">
                    <div class="detail-label">ID</div>
                    <div class="detail-value">{{ $category->id }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Name</div>
                    <div class="detail-value">{{ $category->name }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Slug</div>
                    <div class="detail-value">{{ $category->slug }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Description</div>
                    <div class="detail-value">{{ $category->description ?: 'N/A' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Parent Category</div>
                    <div class="detail-value">{{ $category->parent ? $category->parent->name : 'None' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="badge {{ $category->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Sort Order</div>
                    <div class="detail-value">{{ $category->sort_order }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Products Count</div>
                    <div class="detail-value">{{ $category->products()->count() }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Created At</div>
                    <div class="detail-value">{{ $category->created_at->format('Y-m-d H:i:s') }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Updated At</div>
                    <div class="detail-value">{{ $category->updated_at->format('Y-m-d H:i:s') }}</div>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Edit Category</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to Categories</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>