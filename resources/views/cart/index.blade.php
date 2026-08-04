@extends('layouts.app')

@section('title', 'Shopping Cart - Tech Inventory')

@section('content')
    <header class="app-header">
        <h1>Shopping Cart</h1>
        <p>Review your items before checkout</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if(count($products) === 0)
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; color: var(--color-primary-400);"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <p>Your cart is empty.</p>
            <a href="{{ route('inventory.index') }}" class="btn btn-primary" style="margin-top: 1rem;">Continue Shopping</a>
        </div>
    @else
        <div class="data-card" style="margin-bottom: 1.5rem;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $item)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    @if($item['product']->image)
                                        <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                    @endif
                                    <a href="{{ route('inventory.product', $item['product']->slug) }}" style="font-weight: 600; color: var(--color-text-main); text-decoration: none;">
                                        {{ $item['product']->name }}
                                    </a>
                                </div>
                            </td>
                            <td>${{ number_format($item['product']->price, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item['product']->slug) }}" method="POST" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->quantity + $item['quantity'] }}" class="form-input" style="width: 80px;">
                                    <button type="submit" class="btn btn-secondary btn-sm">Update</button>
                                </form>
                            </td>
                            <td style="font-weight: 700; color: var(--color-primary-600);">${{ number_format($item['subtotal'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['product']->slug) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1.5rem;">
            <div>
                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear your cart?')">
                    @csrf
                    <button type="submit" class="btn btn-danger">Clear Cart</button>
                </form>
            </div>

            <div class="form-card" style="max-width: 360px; width: 100%;">
                <h3 style="margin-bottom: 1rem; font-size: 1.25rem;">Order Summary</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--color-text-muted);">Subtotal</span>
                    <span style="font-weight: 600;">${{ number_format($subtotal, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; padding-top: 0.75rem; border-top: 1px solid var(--color-border);">
                    <span style="font-weight: 700; color: var(--color-text-main);">Total</span>
                    <span style="font-weight: 800; color: var(--color-primary-600); font-size: 1.25rem;">${{ number_format($subtotal, 2) }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="width: 100%;">Proceed to Checkout</a>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary" style="width: 100%; margin-top: 0.75rem;">Continue Shopping</a>
            </div>
        </div>
    @endif
@endsection
