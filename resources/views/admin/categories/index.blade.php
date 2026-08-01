<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; margin-bottom: 30px; border-radius: 12px; }
        .header h1 { margin-bottom: 10px; font-weight: 700; }
        .header p { opacity: 0.9; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: 500; transition: all 0.3s ease; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); }
        .btn-danger { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        .btn-danger:hover { background: #fecaca; }
        .btn-success { background: #dbeafe; color: #1e40af; border: 1px solid #3b82f6; }
        .btn-success:hover { background: #bfdbfe; }
        .table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .table th, .table td { padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .table th { background: #f8fafc; font-weight: 600; color: #1e293b; }
        .table tr:hover { background: #f8fafc; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .badge-active { background: #dbeafe; color: #1e40af; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #dbeafe; color: #1e40af; border: 1px solid #3b82f6; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        .actions { display: flex; gap: 5px; }
        .actions a { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>📦 Category Management</h1>
            <p>Manage your product categories</p>
        </div>
    </div>

    <div class="container">
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
</body>
</html>