<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details - Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #ffffff; color: #202124; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background: #4285F4; color: white; padding: 24px; margin-bottom: 30px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { margin-bottom: 8px; font-weight: 500; font-size: 24px; }
        .header p { opacity: 0.9; font-size: 14px; }
        .detail-container { background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); border: 1px solid #e0e0e0; }
        .detail-row { margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #e0e0e0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 500; color: #202124; margin-bottom: 4px; font-size: 14px; }
        .detail-value { color: #5f6368; font-size: 14px; }
        .badge { padding: 4px 8px; border-radius: 2px; font-size: 12px; font-weight: 500; }
        .badge-active { background: #e8f5e9; color: #137333; }
        .badge-inactive { background: #ffebee; color: #c62828; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: 500; transition: all 0.2s ease; font-size: 14px; }
        .btn-primary { background: #4285F4; color: white; }
        .btn-primary:hover { background: #3367D6; }
        .btn-secondary { background: #f1f3f4; color: #202124; }
        .btn-secondary:hover { background: #e8eaed; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Category Details</h1>
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