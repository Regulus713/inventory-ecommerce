@extends('layouts.admin')

@section('title', 'Edit Category - Admin')

@section('content')
    <header class="app-header">
        <h1>Edit Category</h1>
        <p>Update category: {{ $category->name }}</p>
    </header>

    <div class="form-card">
        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Category Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="form-input" required>
                @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="slug">Slug *</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" class="form-input" required>
                @error('slug')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-textarea">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="parent_id">Parent Category</label>
                <select id="parent_id" name="parent_id" class="form-select">
                    <option value="">No Parent</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Category Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="form-input">
                @if($category->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="max-width: 200px; border-radius: 8px;">
                        <p class="text-sm text-gray-500 mt-1">Current image</p>
                    </div>
                @endif
                @error('image')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="form-input">
                @error('sort_order')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_active" class="mb-0">Active</label>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
