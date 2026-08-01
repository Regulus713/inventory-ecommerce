<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #ffffff; color: #202124; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background: #4285F4; color: white; padding: 24px; margin-bottom: 30px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { margin-bottom: 8px; font-weight: 500; font-size: 24px; }
        .header p { opacity: 0.9; font-size: 14px; }
        .form-container { background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); border: 1px solid #e0e0e0; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #202124; font-size: 14px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 14px; background: white; color: #202124; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #4285F4; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: 500; transition: all 0.2s ease; font-size: 14px; }
        .btn-primary { background: #4285F4; color: white; }
        .btn-primary:hover { background: #3367D6; }
        .btn-secondary { background: #f1f3f4; color: #202124; }
        .btn-secondary:hover { background: #e8eaed; }
        .checkbox-group { display: flex; align-items: center; gap: 8px; }
        .checkbox-group input { width: auto; }
        .error { color: #ea4335; font-size: 12px; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Edit Category</h1>
            <p>Update category: {{ $category->name }}</p>
        </div>
    </div>

    <div class="container">
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
</body>
</html>