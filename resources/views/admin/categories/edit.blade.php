<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Admin</title>
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
        .form-container { 
            background: white; 
            padding: 32px; 
            border-radius: 20px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 10px; font-weight: 600; color: #1a1a2e; font-size: 14px; }
        .form-group input, .form-group textarea, .form-group select { 
            width: 100%; 
            padding: 14px 16px; 
            border: 2px solid #e9ecef; 
            border-radius: 12px; 
            font-size: 14px; 
            background: white;
            color: #1a1a2e;
            transition: all 0.3s ease;
        }
        .form-group textarea { resize: vertical; min-height: 120px; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { 
            outline: none; 
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
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
        .checkbox-group { display: flex; align-items: center; gap: 12px; }
        .checkbox-group input { width: auto; }
        .error { color: #ee5a24; font-size: 13px; margin-top: 6px; font-weight: 500; }
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
                <h1>Edit Category</h1>
                <p>Update category: {{ $category->name }}</p>
            </div>

            <div class="form-container">
                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Category Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug *</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required>
                        @error('slug')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Parent Category</label>
                        <select id="parent_id" name="parent_id">
                            <option value="">No Parent</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Category Image</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        @if($category->image)
                            <div style="margin-top: 10px;">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="max-width: 200px; border-radius: 4px;">
                                <p style="font-size: 12px; color: #6b7280; margin-top: 5px;">Current image</p>
                            </div>
                        @endif
                        @error('image')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sort_order">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}">
                        @error('sort_order')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <label for="is_active" style="margin: 0;">Active</label>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>