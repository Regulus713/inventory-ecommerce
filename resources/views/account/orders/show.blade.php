@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' - Tech Inventory')

@section('content')
    <nav class="breadcrumb">
        <a href="{{ route('account.orders.index') }}">My Orders</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span>{{ $order->order_number }}</span>
    </nav>

    <header class="app-header">
        <h1>Order {{ $order->order_number }}</h1>
        <p>Placed on {{ $order->created_at->format('M j, Y g:i A') }}</p>
    </header>

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
                    <h3>Shipping & Payment</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <p><strong>Status:</strong> <span class="order-status-badge {{ $order->status }}">{{ $order->status }}</span></p>
                    <p><strong>Payment Status:</strong> <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">{{ $order->payment_status }}</span></p>
                    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}</p>
                    @if($order->shipping_address)
                        <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                    @endif
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
