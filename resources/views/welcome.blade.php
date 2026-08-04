<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tech Inventory') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="welcome-page">
        <div class="welcome-card">
            <header class="welcome-header">
                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-secondary btn-sm">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <div class="welcome-body">
                <div class="welcome-hero">
                    <h1>Tech Inventory <span>E-Commerce</span></h1>
                    <p>Manage your technology products with ease. Track laptops, monitors, peripherals, components, and networking equipment in one modern platform.</p>
                    <div class="welcome-actions">
                        <a href="{{ route('inventory.index') }}" class="btn btn-primary">
                            Browse Inventory
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">Get Started</a>
                        @endif
                    </div>
                </div>
                <div class="welcome-visual">
                    <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="12" x="3" y="4" rx="2" ry="2"/><line x1="2" x2="22" y1="20" y2="20"/></svg>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
