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
        <form method="GET" action="{{ route('admin.users.index') }}" id="user-search-form" class="header-search-form" style="flex: 1; max-width: 300px;">
            <input type="text" name="q" id="user-search-input" class="header-search-input" placeholder="Search users..." value="{{ $search }}" autocomplete="off">
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

    <div id="users-search-results">
        @if($users->count() > 0)
        <div class="dashboard-section">
            <div class="dashboard-section-body">
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
                            <tr class="clickable-row" data-href="{{ route('admin.users.show', $user->id) }}" onclick="if (!event.target.closest('a, button, form, label, input, .toggle-switch, .user-avatar')) window.location.href = this.dataset.href;">
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
    </div>
@endsection
