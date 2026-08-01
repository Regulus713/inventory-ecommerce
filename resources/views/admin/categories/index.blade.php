<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: #ffffff;
            color: #1a1a2e;
            min-height: 100vh;
        }
        .container { max-width: 1400px; margin: 0 auto; padding: 0; display: flex; }
        .sidebar { 
            width: 260px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 24px; 
            position: sticky; 
            top: 20px; 
            height: fit-content;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
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
        .main-content { flex: 1; padding: 20px; }
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
        .btn { 
            padding: 10px 20px; 
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
        .btn-danger { 
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(238, 90, 36, 0.3);
        }
        .btn-danger:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(238, 90, 36, 0.4);
        }
        .btn-success { 
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(68, 160, 141, 0.3);
        }
        .btn-success:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(68, 160, 141, 0.4);
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white; 
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }
        .table th, .table td { padding: 16px 20px; text-align: left; border-bottom: 1px solid #e9ecef; }
        .table th { 
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-weight: 700; 
            color: #1a1a2e; 
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table tr:hover { background: #f8f9fa; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-active { background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%); color: #0f5132; }
        .badge-inactive { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: #c92a2a; }
        .alert { padding: 20px; border-radius: 16px; margin-bottom: 24px; font-size: 14px; font-weight: 500; }
        .alert-success { 
            background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
            color: #0f5132; 
            border: 1px solid #96e6a1;
        }
        .alert-error { 
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            color: #c92a2a; 
            border: 1px solid #ff9a9e;
        }
        .actions { display: flex; gap: 8px; }
        .actions a { padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
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
        <div class="main-content">
            <div class="header">
                <h1>Category Management</h1>
                <p>Manage your product categories</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div style="margin-bottom: 20px;">
                <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Add New Category</a>
                <a href="{{ route('inventory.index') }}" class="btn btn-success">← Back to Inventory</a>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Sort Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ Str::limit($category->description, 50) }}</td>
                            <td>
                                <span class="badge {{ $category->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $category->sort_order }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('categories.show', $category->id) }}" style="background: #3b82f6; color: white;">View</a>
                                    <a href="{{ route('categories.edit', $category->id) }}" style="background: #f59e0b; color: white;">Edit</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #dc2626; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($categories->count() === 0)
                <p style="text-align: center; color: #6b7280; padding: 40px;">No categories found. <a href="{{ route('categories.create') }}">Create one</a></p>
            @endif
        </div>
    </div>
</body>
</html>