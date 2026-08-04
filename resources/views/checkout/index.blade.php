@extends('layouts.app')

@section('title', 'Checkout - Tech Inventory')

@section('content')
    <header class="app-header">
        <h1>Checkout</h1>
        <p>Complete your dummy purchase</p>
    </header>

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="checkout-grid">
        <div>
            <div class="form-card">
                <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Customer Information</h3>
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="customer_name">Full Name *</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" class="form-input" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="customer_email">Email Address *</label>
                            <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="customer_phone">Phone Number</label>
                            <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" class="form-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="shipping_address">Shipping Address *</label>
                        <textarea id="shipping_address" name="shipping_address" class="form-textarea" required>{{ old('shipping_address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="notes">Order Notes</label>
                        <textarea id="notes" name="notes" class="form-textarea">{{ old('notes') }}</textarea>
                    </div>

                    <div class="form-group flex items-center gap-3">
                        <input type="checkbox" id="terms" name="terms" required class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="terms" class="mb-0" style="color: var(--color-text-muted);">I agree this is a dummy checkout and no real payment will be processed.</label>
                    </div>

                    <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">Place Dummy Order</button>
                        <a href="{{ route('cart.index') }}" class="btn btn-secondary">Back to Cart</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="form-card" style="width: 100%;">
            <h3 style="margin-bottom: 1.25rem; font-size: 1.25rem;">Order Summary</h3>

            <div style="margin-bottom: 1.5rem;">
                @foreach($products as $item)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--color-border);">
                        <div>
                            <div style="font-weight: 600; color: var(--color-text-main);">{{ $item['product']->name }}</div>
                            <div style="font-size: 0.85rem; color: var(--color-text-subtle);">Qty: {{ $item['quantity'] }}</div>
                        </div>
                        <div style="font-weight: 600;">${{ number_format($item['subtotal'], 2) }}</div>
                    </div>
                @endforeach
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; color: var(--color-text-muted);">
                <span>Subtotal</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; color: var(--color-text-muted);">
                <span>Tax (8%)</span>
                <span>${{ number_format($tax, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border); color: var(--color-text-muted);">
                <span>Shipping</span>
                <span>{{ $shipping === 0 ? 'Free' : '$' . number_format($shipping, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 700; color: var(--color-text-main); font-size: 1.1rem;">Total</span>
                <span style="font-weight: 800; color: var(--color-primary-600); font-size: 1.5rem;">${{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>
@endsection
