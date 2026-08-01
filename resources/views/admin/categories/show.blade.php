<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details - Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; margin-bottom: 30px; border-radius: 12px; }
        .header h1 { margin-bottom: 10px; font-weight: 700; }
        .header p { opacity: 0.9; }
        .detail-container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .detail-row { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e2e8f0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: #1e293b; margin-bottom: 5px; }
        .detail-value { color: #64748b; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .badge-active { background: #dbeafe; color: #1e40af; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: 500; transition: all 0.3s ease; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); }
        .btn-secondary { background: #e2e8f0; color: #1e293b; }
        .btn-secondary:hover { background: #cbd5e1; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>📦 Category Details</h1>
            <p>View category information</p>
        </div>
    </div>

    <div class="container">
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
</body>
</html>