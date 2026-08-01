<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin</title>
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
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.15);
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
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
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
            background: #6366f1;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(99, 102, 241, 0.2);
        }
        .btn-secondary {
            background: #f8f9fa;
            color: #6366f1;
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
    <div class="content-wrapper">
        <div class="container">
        <div class="main-content">
            <div class="header">
                <h1>Edit Product</h1>
                <p>Update product: {{ $product->name }}</p>
            </div>

            <div class="form-container">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="slug">Slug *</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required>
                            @error('slug')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU *</label>
                            <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="category_id">Category *</label>
                            <select id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <input type="text" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}">
                            @error('barcode')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Price ($) *</label>
                            <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="compare_price">Compare Price ($)</label>
                            <input type="number" id="compare_price" name="compare_price" step="0.01" value="{{ old('compare_price', $product->compare_price) }}">
                            @error('compare_price')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="quantity">Quantity *</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
                            @error('quantity')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="low_stock_threshold">Low Stock Threshold *</label>
                            <input type="number" id="low_stock_threshold" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" required>
                            @error('low_stock_threshold')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="manufacturer">Manufacturer</label>
                            <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $product->manufacturer) }}">
                            @error('manufacturer')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" id="model" name="model" value="{{ old('model', $product->model) }}">
                            @error('model')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="warranty">Warranty</label>
                            <input type="text" id="warranty" name="warranty" value="{{ old('warranty', $product->warranty) }}">
                            @error('warranty')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="weight">Weight (kg)</label>
                            <input type="number" id="weight" name="weight" step="0.01" value="{{ old('weight', $product->weight) }}">
                            @error('weight')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dimensions">Dimensions</label>
                        <input type="text" id="dimensions" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="e.g., 24.4 x 16.8 x 1.6 cm">
                        @error('dimensions')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Main Image</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        @if($product->image)
                            <div style="margin-top: 10px;">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 200px; border-radius: 4px;">
                                <p style="font-size: 12px; color: #6b7280; margin-top: 5px;">Current image</p>
                            </div>
                        @endif
                        @error('image')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label for="is_active" style="margin: 0;">Active</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label for="is_featured" style="margin: 0;">Featured Product</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="is_digital" name="is_digital" value="1" {{ old('is_digital', $product->is_digital) ? 'checked' : '' }}>
                            <label for="is_digital" style="margin: 0;">Digital Product</label>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>