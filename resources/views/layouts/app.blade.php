<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Tech Inventory'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body {{ auth()->check() && auth()->user()->isAdmin() ? 'class="admin-sidebar"' : '' }}>
    @include('partials.site-header')

    @if(auth()->check() && auth()->user()->isAdmin())
        @include('partials.admin-sidebar')
    @endif

    <main class="{{ auth()->check() && auth()->user()->isAdmin() ? 'app-content' : 'main-content' }}" id="pjax-main">
        <div class="app-container">
            <div class="app-main">
                @yield('content')
            </div>
        </div>
    </main>

    <div class="cart-overlay" id="cart-overlay"></div>
    @include('partials.cart-sidebar')

    <div class="toast" id="toast" role="status" aria-live="polite">
        <span class="toast-message" id="toast-message"></span>
    </div>
</body>
</html>
