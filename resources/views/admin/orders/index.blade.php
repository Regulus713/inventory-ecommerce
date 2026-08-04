@extends('layouts.admin')

@section('title', 'Orders - Admin')

@section('content')
    <header class="app-header">
        <h1>Order Management</h1>
        <p>View and manage all customer orders</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="product-toolbar">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="header-search-form" style="flex: 1; max-width: 300px;">
            <input type="text" name="q" class="header-search-input" placeholder="Search orders..." value="{{ $search }}" autocomplete="off">
        </form>
        <div class="product-sort">
            <label for="status-filter">Status</label>
            <select id="status-filter" class="form-select" onchange="window.location.href = this.value;">
                @php($statusOptions = ['all' => 'All Status', 'pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'])
                @foreach($statusOptions as $value => $label)
                    <option value="{{ request()->fullUrlWithQuery(['status' => $value, 'page' => 1]) }}" {{ $status === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="dashboard-section">
            <div class="dashboard-section-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
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
                                <td>{{ $order->user?->name ?? $order->contact_email ?? 'Guest' }}</td>
                                <td>{{ $order->items->count() }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td><span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">{{ $order->payment_status }}</span></td>
                                <td><span class="order-status-badge {{ $order->status }}">{{ $order->status }}</span></td>
                                <td>{{ $order->created_at->format('M j, Y g:i A') }}</td>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">View</a></td>
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
            <p>No orders found.</p>
        </div>
    @endif
@endsection
