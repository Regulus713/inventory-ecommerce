@extends('layouts.app')

@section('title', 'My Orders - Tech Inventory')

@section('content')
    <header class="app-header">
        <h1>My Orders</h1>
        <p>View all of your orders</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->count() > 0)
        <div class="dashboard-section">
            <div class="dashboard-section-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td><span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">{{ $order->payment_status }}</span></td>
                                <td><span class="order-status-badge {{ $order->status }}">{{ $order->status }}</span></td>
                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                                <td><a href="{{ route('account.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders->hasPages())
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <p>You haven't placed any orders yet.</p>
            <a href="{{ route('inventory.index') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @endif
@endsection
