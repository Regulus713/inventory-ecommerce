<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #ffffff; color: #202124; }
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .header { background: #4285F4; color: white; padding: 24px; margin-bottom: 30px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { margin-bottom: 8px; font-weight: 500; font-size: 24px; }
        .header p { opacity: 0.9; font-size: 14px; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: 500; transition: all 0.2s ease; font-size: 14px; }
        .btn-primary { background: #4285F4; color: white; }
        .btn-primary:hover { background: #3367D6; }
        .btn-danger { background: #ea4335; color: white; }
        .btn-danger:hover { background: #d93025; }
        .btn-success { background: #34a853; color: white; }
        .btn-success:hover { background: #2d9e4d; }
        .table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); border: 1px solid #e0e0e0; }
        .table th, .table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .table th { background: #f8f9fa; font-weight: 500; color: #202124; font-size: 14px; }
        .table tr:hover { background: #f8f9fa; }
        .badge { padding: 4px 8px; border-radius: 2px; font-size: 12px; font-weight: 500; }
        .badge-active { background: #e8f5e9; color: #137333; }
        .badge-inactive { background: #ffebee; color: #c62828; }
        .badge-featured { background: #fff3e0; color: #f57c00; }
        .stock-good { background: #e8f5e9; color: #137333; }
        .stock-low { background: #fff3e0; color: #f57c00; }
        .stock-out { background: #ffebee; color: #c62828; }
        .alert { padding: 16px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #e8f5e9; color: #137333; border: 1px solid #34a853; }
        .alert-error { background: #ffebee; color: #c62828; border: 1px solid #ea4335; }
        .actions { display: flex; gap: 8px; }
        .actions a { padding: 4px 8px; border-radius: 2px; text-decoration: none; font-size: 12px; font-weight: 500; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Product Management</h1>
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
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            @endif
                            {{ $product->name }}
                        </td>
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