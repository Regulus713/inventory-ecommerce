<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel')</title>
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
<body class="admin-sidebar">
    @include('partials.site-header')

    <div class="app-layout">
        @include('partials.admin-sidebar')

        <main class="app-content">
            <div class="app-container">
                <div class="app-main">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>
