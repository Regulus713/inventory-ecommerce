@extends('layouts.app')

@section('title', 'Profile - Tech Inventory')

@section('content')
    <header class="app-header">
        <h1>Your Profile</h1>
        <p>Manage your account details and security</p>
    </header>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="dashboard-section">
        <div class="dashboard-section-body">
            <livewire:profile.update-profile-information-form />
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-section-body">
            <livewire:profile.update-password-form />
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-section-body">
            <livewire:profile.delete-user-form />
        </div>
    </div>
@endsection
