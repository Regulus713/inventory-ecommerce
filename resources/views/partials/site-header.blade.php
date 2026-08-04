<div class="site-header-wrapper">
    <header class="site-header">
        <div class="header-top">
            <div class="header-left">
                <button class="mobile-menu-btn" aria-label="Open navigation menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                </button>
                <a href="{{ route('inventory.index') }}" class="header-logo" data-pjax="main">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="12" x="3" y="4" rx="2" ry="2"/><line x1="2" x2="22" y1="20" y2="20"/></svg>
                    Tech Inventory
                </a>
            </div>

            <div class="header-search">
                <form action="{{ route('inventory.index') }}" method="GET" class="header-search-form" id="product-search-form" data-category="{{ $currentCategory ?? '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="header-search-icon"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input
                        type="text"
                        name="q"
                        id="product-search-input"
                        class="header-search-input"
                        placeholder="Search products..."
                        value="{{ request('q') }}"
                        autocomplete="off"
                    >
                </form>
            </div>

            <div class="header-actions">
                <a href="#" class="header-action" title="Notifications" aria-label="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="header-action" title="Dashboard" aria-label="Dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="header-action" title="Admin Panel" aria-label="Admin Panel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        </a>
                    @endif
                    <a href="{{ route('profile') }}" class="header-action" title="Profile" aria-label="Profile">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="header-action" title="Log Out" aria-label="Log Out" style="border: none; background: transparent; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        </button>
                    </form>
                @else
                    <div class="header-action header-action-dropdown" title="Log In" aria-label="Log In" tabindex="0">
                        <span class="header-action-trigger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="3 8 7 12 3 16"/><line x1="7" x2="21" y1="12" y2="12"/></svg>
                        </span>
                        <div class="header-dropdown login-dropdown">
                            <livewire:auth.login-dropdown />
                        </div>
                    </div>
                    <a href="{{ route('register') }}" class="header-action" title="Register" aria-label="Register">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><line x1="20" x2="4" y1="12" y2="12"/></svg>
                    </a>
                @endauth
                <button class="header-action" id="theme-toggle" title="Toggle theme" aria-label="Toggle theme" type="button">
                    <svg id="theme-icon-moon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                    <svg id="theme-icon-sun" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                </button>
                <button class="header-action header-cart" id="cart-toggle" title="Cart" aria-label="Cart" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <span class="header-cart-count" id="header-cart-count" style="{{ $cartCount > 0 ? '' : 'display: none;' }}">{{ $cartCount }}</span>
                </button>
            </div>
        </div>

        <nav class="header-categories" id="header-categories">
            <a href="{{ route('inventory.index') }}" class="header-category-link {{ request()->routeIs('inventory.index') ? 'active' : '' }}" data-pjax="main">All Products</a>
            @foreach($categories as $category)
                <a href="{{ route('inventory.category', $category->slug) }}" class="header-category-link {{ request()->is('category/' . $category->slug) ? 'active' : '' }}" data-pjax="main">
                    {{ $category->name }}
                </a>
            @endforeach
        </nav>

        <div class="sidebar-overlay"></div>
        <nav class="mobile-nav">
            <div class="mobile-nav-header">
                <span class="header-logo">Categories</span>
                <button class="mobile-close-btn" aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            <div class="mobile-nav-links" id="mobile-nav-links">
                <a href="{{ route('inventory.index') }}" class="mobile-nav-link {{ request()->routeIs('inventory.index') ? 'active' : '' }}" data-pjax="main">All Products</a>
                @foreach($categories as $category)
                    <a href="{{ route('inventory.category', $category->slug) }}" class="mobile-nav-link {{ request()->is('category/' . $category->slug) ? 'active' : '' }}" data-pjax="main">{{ $category->name }}</a>
                @endforeach
            </div>
        </nav>
    </header>
</div>