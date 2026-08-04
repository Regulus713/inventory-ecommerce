<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Tech Inventory'))</title>
    <script>
        (function () {
            const saved = localStorage.getItem('theme');
            if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ auth()->check() ? (auth()->user()->isAdmin() ? 'admin-sidebar' : 'user-sidebar') : '' }}">
    @include('partials.site-header')

    @if(auth()->check())
        @if(auth()->user()->isAdmin())
            @include('partials.admin-sidebar')
        @else
            @include('partials.user-sidebar')
        @endif
    @endif

    <main class="{{ auth()->check() ? (auth()->user()->isAdmin() ? 'app-content' : 'main-content user-content') : 'main-content' }}" id="pjax-main">
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
