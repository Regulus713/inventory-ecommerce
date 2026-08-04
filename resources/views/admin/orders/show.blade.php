@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number . ' - Admin')

@section('content')
    <nav class="breadcrumb">
        <a href="{{ route('admin.orders.index') }}">Orders</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span>{{ $order->order_number }}</span>
    </nav>

    <header class="app-header">
        <h1>Order {{ $order->order_number }}</h1>
        <p>Placed on {{ $order->created_at->format('M j, Y g:i A') }}</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="checkout-grid">
        <div>
            <div class="dashboard-section">
                <div class="dashboard-section-header">
                    <h3>Order Items</h3>
                </div>
                <div class="dashboard-section-body">
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
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->product_sku }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dashboard-section">
                <div class="dashboard-section-header">
                    <h3>Update Status</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" style="display: flex; gap: 0.75rem; align-items: flex-end;">
                        @csrf
                        <div class="form-group" style="flex: 1; margin: 0;">
                            <label class="form-label" for="status">Order Status</label>
                            <select name="status" id="status" class="form-select">
                                @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <div class="dashboard-section">
                <div class="dashboard-section-header">
                    <h3>Order Summary</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <div class="cart-summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Tax</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Shipping</span>
                        <span>${{ number_format($order->shipping, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="cart-summary-row">
                            <span>Discount</span>
                            <span>-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="cart-summary-total">
                        <span>Total</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="dashboard-section">
                <div class="dashboard-section-header">
                    <h3>Customer Info</h3>
                </div>
                <div style="padding: 1.5rem;">
                    @if($order->user)
                        <p><strong>Account:</strong> {{ $order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    @else
                        <p><strong>Guest checkout</strong></p>
                        <p><strong>Email:</strong> {{ $order->contact_email ?? 'N/A' }}</p>
                    @endif
                    @if($order->contact_phone)
                        <p><strong>Phone:</strong> {{ $order->contact_phone }}</p>
                    @endif
                    @if($order->shipping_address)
                        <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                    @endif
                    @if($order->notes)
                        <p><strong>Notes:</strong> {{ $order->notes }}</p>
                    @endif
                    <hr style="margin: 1rem 0; border: none; border-top: 1px solid var(--color-border);">
                    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Payment Status:</strong> <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">{{ $order->payment_status }}</span></p>
                    <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}</p>
                    @if($order->shipped_at)
                        <p><strong>Shipped At:</strong> {{ $order->shipped_at->format('M j, Y g:i A') }}</p>
                    @endif
                    @if($order->delivered_at)
                        <p><strong>Delivered At:</strong> {{ $order->delivered_at->format('M j, Y g:i A') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
