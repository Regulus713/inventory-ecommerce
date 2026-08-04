@extends('layouts.admin')

@section('title', $user->name . ' - Admin')

@section('content')
    <nav class="breadcrumb">
        <a href="{{ route('admin.users.index') }}">Users</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span>{{ $user->name }}</span>
    </nav>

    <header class="app-header">
        <h1>{{ $user->name }}</h1>
        <p>{{ $user->email }}</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="checkout-grid">
        <div>
            <div class="dashboard-section">
                <div class="dashboard-section-header">
                    <h3>User Details</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <div class="user-avatar" style="width: 4rem; height: 4rem; font-size: 1.75rem;">{{ strtoupper($user->name[0]) }}</div>
                        <div>
                            <h2 style="margin: 0; font-size: 1.5rem;">{{ $user->name }}</h2>
                            <p style="margin: 0.25rem 0 0 0; color: var(--color-text-muted);">{{ $user->email }}</p>
                        </div>
                    </div>
                    <p><strong>Role:</strong> <span class="role-badge {{ $user->role }}">{{ $user->role }}</span></p>
                    <p><strong>Joined:</strong> {{ $user->created_at->format('M j, Y') }}</p>
                    <p><strong>Email Verified:</strong> {{ $user->email_verified_at ? 'Yes' : 'No' }}</p>
                    <p><strong>Total Orders:</strong> {{ $user->orders_count }}</p>
                </div>
            </div>

            <div class="dashboard-section">
                <div class="dashboard-section-header">
                    <h3>Change Role</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <form action="{{ route('admin.users.role', $user->id) }}" method="POST" style="display: flex; gap: 0.75rem; align-items: flex-end;">
                        @csrf
                        <div class="form-group" style="flex: 1; margin: 0;">
                            <label class="form-label" for="role">User Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <div class="dashboard-section">
                <div class="dashboard-section-header">
                    <h3>Order History</h3>
                </div>
                <div class="dashboard-section-body">
                    @if($orders->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td><a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a></td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td><span class="order-status-badge {{ $order->status }}">{{ $order->status }}</span></td>
                                        <td>{{ $order->created_at->format('M j, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($orders->hasPages())
                            <div style="padding: 1rem;">{{ $orders->links() }}</div>
                        @endif
                    @else
                        <p style="padding: 1.5rem; text-align: center; color: var(--color-text-muted);">No orders yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
