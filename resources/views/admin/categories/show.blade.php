@extends('layouts.admin')

@section('title', 'Category Details - Admin')

@section('content')
    <header class="app-header">
        <h1>Category Details</h1>
        <p>View category information</p>
    </header>

    <div class="form-card" style="max-width: 700px;">
        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">ID</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $category->id }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Name</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $category->name }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Slug</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $category->slug }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Description</div>
            <div style="color: var(--color-text-muted); line-height: 1.6;">{{ $category->description ?: 'N/A' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Parent Category</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $category->parent ? $category->parent->name : 'None' }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Status</div>
            <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                {{ $category->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Sort Order</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $category->sort_order }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Products Count</div>
            <div style="color: var(--color-text-main); font-weight: 500;">{{ $category->products()->count() }}</div>
        </div>

        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Created At</div>
            <div style="color: var(--color-text-muted);">{{ $category->created_at->format('Y-m-d H:i:s') }}</div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--color-text-subtle); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.03em;">Updated At</div>
            <div style="color: var(--color-text-muted);">{{ $category->updated_at->format('Y-m-d H:i:s') }}</div>
        </div>

        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Edit Category</a>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to Categories</a>
        </div>
    </div>
@endsection
