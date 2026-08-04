@extends('layouts.app')

@section('title', 'Order Confirmed - Tech Inventory')

@section('content')
    <header class="app-header">
        <h1>Order Confirmed!</h1>
        <p>Thank you for your dummy purchase</p>
    </header>

    <div class="form-card" style="max-width: 800px; margin: 0 auto;">
        <div class="alert alert-success" style="text-align: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 0.5rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <div style="font-weight: 700; font-size: 1.1rem;">Your order has been placed successfully</div>
            <div style="color: var(--color-text-subtle); margin-top: 0.25rem;">Order number: <strong>{{ $order->order_number }}</strong></div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem; color: var(--color-text-main);">Order Details</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div style="background: var(--color-surface-soft); padding: 1rem; border-radius: var(--radius-md);">
                    <div style="font-size: 0.8rem; color: var(--color-text-subtle); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 0.25rem;">Order Number</div>
                    <div style="font-weight: 700; color: var(--color-text-main);">{{ $order->order_number }}</div>
                </div>
                <div style="background: var(--color-surface-soft); padding: 1rem; border-radius: var(--radius-md);">
                    <div style="font-size: 0.8rem; color: var(--color-text-subtle); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 0.25rem;">Order Date</div>
                    <div style="font-weight: 700; color: var(--color-text-main);">{{ $order->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div style="background: var(--color-surface-soft); padding: 1rem; border-radius: var(--radius-md);">
                    <div style="font-size: 0.8rem; color: var(--color-text-subtle); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 0.25rem;">Payment Status</div>
                    <span class="badge badge-success">{{ ucfirst($order->payment_status) }}</span>
                </div>
                <div style="background: var(--color-surface-soft); padding: 1rem; border-radius: var(--radius-md);">
                    <div style="font-size: 0.8rem; color: var(--color-text-subtle); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 0.25rem;">Order Status</div>
                    <span class="badge badge-warning">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem; color: var(--color-text-main);">Items</h3>
            <div class="data-card" style="overflow: hidden;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td style="font-weight: 600;">{{ $item->product_name }}</td>
                                <td>{{ $item->product_sku }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td style="font-weight: 700; color: var(--color-primary-600);">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; padding: 1rem; background: var(--color-surface-soft); border-radius: var(--radius-md);">
            <div style="text-align: right; width: 100%;">
                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-bottom: 0.5rem; color: var(--color-text-muted);">
                    <span>Subtotal:</span>
                    <span style="min-width: 80px;">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-bottom: 0.5rem; color: var(--color-text-muted);">
                    <span>Tax:</span>
                    <span style="min-width: 80px;">${{ number_format($order->tax, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-bottom: 0.5rem; color: var(--color-text-muted);">
                    <span>Shipping:</span>
                    <span style="min-width: 80px;">${{ number_format($order->shipping, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-top: 0.5rem; border-top: 1px solid var(--color-border);">
                    <span style="font-weight: 700; color: var(--color-text-main); font-size: 1.1rem;">Total:</span>
                    <span style="font-weight: 800; color: var(--color-primary-600); font-size: 1.1rem; min-width: 80px;">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 0.75rem; justify-content: center;">
            <a href="{{ route('inventory.index') }}" class="btn btn-primary">Continue Shopping</a>
            <a href="{{ route('cart.index') }}" class="btn btn-secondary">View Cart</a>
        </div>
    </div>
@endsection
