@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
    <header class="app-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="dashboard-grid">
        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/></svg>
            </div>
            <div class="dashboard-stat-label">Total Products</div>
            <div class="dashboard-stat-value">{{ $totalProducts }}</div>
        </div>

        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <div class="dashboard-stat-label">Total Orders</div>
            <div class="dashboard-stat-value">{{ $totalOrders }}</div>
        </div>

        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="dashboard-stat-label">Total Users</div>
            <div class="dashboard-stat-value">{{ $totalUsers }}</div>
        </div>

        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="dashboard-stat-label">Total Revenue</div>
            <div class="dashboard-stat-value">${{ number_format($totalRevenue, 2) }}</div>
        </div>

        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="dashboard-stat-label">Pending Orders</div>
            <div class="dashboard-stat-value">{{ $pendingOrders }}</div>
        </div>

        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon red">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
            </div>
            <div class="dashboard-stat-label">Low / Out of Stock</div>
            <div class="dashboard-stat-value">{{ $lowStockProducts }} / {{ $outOfStockProducts }}</div>
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-section-header">
            <h3>Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="dashboard-section-body">
            @if($recentOrders->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
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
                                <td>{{ $order->user?->name ?? $order->contact_email ?? 'Guest' }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td><span class="order-status-badge {{ $order->status }}">{{ $order->status }}</span></td>
                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="padding: 1.5rem; text-align: center; color: var(--color-text-muted);">No orders yet.</p>
            @endif
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-section-header">
            <h3>Low Stock Alert</h3>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Manage Products</a>
        </div>
        <div class="dashboard-section-body">
            @if($lowStockItems->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockItems as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category?->name ?? 'N/A' }}</td>
                                <td>
                                    @if($product->quantity === 0)
                                        <span class="badge badge-danger">Out of stock</span>
                                    @else
                                        <span class="badge badge-warning">{{ $product->quantity }} left</span>
                                    @endif
                                </td>
                                <td>${{ number_format($product->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="padding: 1.5rem; text-align: center; color: var(--color-text-muted);">All products are well stocked.</p>
            @endif
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-section-header">
            <h3>Users</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Manage Users</a>
        </div>
        <div class="dashboard-section-body">
            @if($users->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Orders</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div class="user-avatar">{{ strtoupper($user->name[0]) }}</div>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.users.role', $user->id) }}" class="role-toggle-form">
                                        @csrf
                                        <input type="hidden" name="role" id="role-input-{{ $user->id }}" value="{{ $user->role }}">
                                        <label class="toggle-switch">
                                            <input type="checkbox"
                                                   class="toggle-switch-input"
                                                   onchange="document.getElementById('role-input-{{ $user->id }}').value = this.checked ? 'admin' : 'customer'; this.form.submit();"
                                                   {{ $user->isAdmin() ? 'checked' : '' }}
                                                   {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                            <span class="toggle-switch-slider"></span>
                                            <span class="toggle-switch-label">{{ $user->isAdmin() ? 'Admin' : 'Customer' }}</span>
                                        </label>
                                    </form>
                                </td>
                                <td>{{ $user->orders_count }}</td>
                                <td>{{ $user->created_at->format('M j, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary btn-sm">View</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display: inline;" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" {{ $user->id === auth()->id() ? 'disabled' : '' }}>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="padding: 1.5rem; text-align: center; color: var(--color-text-muted);">No users yet.</p>
            @endif
        </div>
    </div>
@endsection
