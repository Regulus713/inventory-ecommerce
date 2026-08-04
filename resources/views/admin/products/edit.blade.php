@extends('layouts.admin')

@section('title', 'Edit Product - Admin')

@section('content')
    <header class="app-header">
        <h1>Edit Product</h1>
        <p>Update product: {{ $product->name }}</p>
    </header>

    <div class="form-card">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="form-input" required>
                @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="slug">Slug *</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" class="form-input" required>
                    @error('slug')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sku">SKU *</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" class="form-input" required>
                    @error('sku')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-textarea">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="barcode">Barcode</label>
                    <input type="text" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}" class="form-input">
                    @error('barcode')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price ($) *</label>
                    <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" class="form-input" required>
                    @error('price')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="compare_price">Compare Price ($)</label>
                    <input type="number" id="compare_price" name="compare_price" step="0.01" value="{{ old('compare_price', $product->compare_price) }}" class="form-input">
                    @error('compare_price')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="quantity">Quantity *</label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="form-input" required>
                    @error('quantity')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="low_stock_threshold">Low Stock Threshold *</label>
                    <input type="number" id="low_stock_threshold" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" class="form-input" required>
                    @error('low_stock_threshold')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="manufacturer">Manufacturer</label>
                    <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $product->manufacturer) }}" class="form-input">
                    @error('manufacturer')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" id="model" name="model" value="{{ old('model', $product->model) }}" class="form-input">
                    @error('model')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="warranty">Warranty</label>
                    <input type="text" id="warranty" name="warranty" value="{{ old('warranty', $product->warranty) }}" class="form-input">
                    @error('warranty')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" step="0.01" value="{{ old('weight', $product->weight) }}" class="form-input">
                    @error('weight')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="dimensions">Dimensions</label>
                <input type="text" id="dimensions" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="e.g., 24.4 x 16.8 x 1.6 cm" class="form-input">
                @error('dimensions')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Main Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="form-input">
                @if($product->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 200px; border-radius: 8px;">
                        <p class="text-sm text-gray-500 mt-1">Current image</p>
                    </div>
                @endif
                @error('image')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_active" class="mb-0">Active</label>
            </div>

            <div class="form-group flex items-center gap-3">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_featured" class="mb-0">Featured Product</label>
            </div>

            <div class="form-group flex items-center gap-3">
                <input type="checkbox" id="is_digital" name="is_digital" value="1" {{ old('is_digital', $product->is_digital) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_digital" class="mb-0">Digital Product</label>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
