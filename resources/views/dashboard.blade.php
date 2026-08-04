@extends('layouts.app')

@section('title', 'Dashboard - Tech Inventory')

@section('content')
    <header class="app-header">
        <h1>Welcome, {{ $user->name }}</h1>
        <p>Here is a summary of your account</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <div class="dashboard-stat-label">Total Orders</div>
            <div class="dashboard-stat-value">{{ $user->orders_count ?? $user->orders()->count() }}</div>
        </div>

        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="dashboard-stat-label">Member Since</div>
            <div class="dashboard-stat-value">{{ $user->created_at->format('M Y') }}</div>
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-section-header">
            <h3>Quick Actions</h3>
        </div>
        <div style="padding: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('account.orders.index') }}" class="btn btn-primary">My Orders</a>
            <a href="{{ route('profile') }}" class="btn btn-secondary">Edit Profile</a>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-section-header">
            <h3>Recent Orders</h3>
            <a href="{{ route('account.orders.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="dashboard-section-body">
            @if($recentOrders->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td><span class="order-status-badge {{ $order->status }}">{{ $order->status }}</span></td>
                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                                <td><a href="{{ route('account.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="padding: 1.5rem; text-align: center; color: var(--color-text-muted);">You haven't placed any orders yet.</p>
            @endif
        </div>
    </div>
@endsection
