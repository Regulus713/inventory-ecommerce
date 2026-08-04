@extends('layouts.admin')

@section('title', 'Users - Admin')

@section('content')
    <header class="app-header">
        <h1>User Management</h1>
        <p>View and manage user accounts</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="product-toolbar">
        <form method="GET" action="{{ route('admin.users.index') }}" class="header-search-form" style="flex: 1; max-width: 300px;">
            <input type="text" name="q" class="header-search-input" placeholder="Search users..." value="{{ $search }}" autocomplete="off">
        </form>
        <div class="product-sort">
            <label for="role-filter">Role</label>
            <select id="role-filter" class="form-select" onchange="window.location.href = this.value;">
                @php($roleOptions = ['all' => 'All Roles', 'admin' => 'Admins', 'customer' => 'Customers'])
                @foreach($roleOptions as $value => $label)
                    <option value="{{ request()->fullUrlWithQuery(['role' => $value, 'page' => 1]) }}" {{ $role === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($users->count() > 0)
        <div class="dashboard-section">
            <div class="dashboard-section-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
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
                                <td>{{ $user->email }}</td>
                                <td><span class="role-badge {{ $user->role }}">{{ $user->role }}</span></td>
                                <td>{{ $user->orders_count }}</td>
                                <td>{{ $user->created_at->format('M j, Y') }}</td>
                                <td><a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary btn-sm">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
            <div class="pagination">
                {{ $users->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <p>No users found.</p>
        </div>
    @endif
@endsection
