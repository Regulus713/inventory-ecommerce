<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .header { background: #1e3a8a; color: white; padding: 20px; margin-bottom: 30px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #1e3a8a; color: white; }
        .btn-primary:hover { background: #1e40af; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-success { background: #059669; color: white; }
        .btn-success:hover { background: #047857; }
        .table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .table th { background: #f9fafb; font-weight: bold; color: #1f2937; }
        .table tr:hover { background: #f9fafb; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .badge-active { background: #d1fae5; color: #065f46; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        .badge-featured { background: #fef3c7; color: #92400e; }
        .stock-good { background: #d1fae5; color: #065f46; }
        .stock-low { background: #fef3c7; color: #92400e; }
        .stock-out { background: #fee2e2; color: #991b1b; }
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        .actions { display: flex; gap: 5px; }
        .actions a { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>🖥️ Product Management</h1>
            <p>Manage your tech products</p>
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
            <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add New Product</a>
            <a href="{{ route('categories.index') }}" class="btn btn-success">Manage Categories</a>
            <a href="{{ route('inventory.index') }}" class="btn btn-success">← Back to Inventory</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge {{ $product->isInStock() ? 'stock-good' : ($product->isLowStock() ? 'stock-low' : 'stock-out') }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td>
                            @if($product->is_featured)
                                <span class="badge badge-featured">Featured</span>
                            @endif
                            <span class="badge {{ $product->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('products.show', $product->id) }}" style="background: #3b82f6; color: white;">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" style="background: #f59e0b; color: white;">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dc2626; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($products->hasPages())
            <div style="margin-top: 30px; text-align: center;">
                {{ $products->links() }}
            </div>
        @endif

        @if($products->count() === 0)
            <p style="text-align: center; color: #6b7280; padding: 40px;">No products found. <a href="{{ route('products.create') }}">Create one</a></p>
        @endif
    </div>
</body>
</html>