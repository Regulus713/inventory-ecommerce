import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    initMobileNavigation();
    initPjax();
    initCartSidebar();
    initRemoveFromCart();
    initLiveSearch();
    initAddToCart();
    initAutoHideFlash();
});

let liveSearchDebounce;

function initMobileNavigation() {
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const closeBtn = document.querySelector('.mobile-close-btn');
    const sidebar = document.querySelector('.app-sidebar');
    const mobileNav = document.querySelector('.mobile-nav');
    const overlay = document.querySelector('.sidebar-overlay');

    const panel = sidebar || mobileNav;
    if (!menuBtn || !panel) return;

    const open = () => {
        panel.classList.add('open');
        if (overlay) overlay.classList.add('open');
    };

    const close = () => {
        panel.classList.remove('open');
        if (overlay) overlay.classList.remove('open');
    };

    menuBtn.addEventListener('click', open);
    if (closeBtn) closeBtn.addEventListener('click', close);
    if (overlay) overlay.addEventListener('click', close);
}

function initPjax() {
    document.body.addEventListener('click', (e) => {
        const link = e.target.closest('[data-pjax="main"]');
        if (!link) return;
        if (link.hostname !== location.hostname) return;
        if (e.ctrlKey || e.metaKey || e.shiftKey) return;

        e.preventDefault();
        pjaxLoad(link.href);
    });

    window.addEventListener('popstate', () => {
        pjaxLoad(location.href, false);
    });
}

async function pjaxLoad(url, updateHistory = true) {
    const main = document.getElementById('pjax-main');
    if (!main) return;

    main.style.opacity = '0.6';
    main.style.transition = 'opacity 0.2s ease';

    try {
        const response = await fetch(url, {
            headers: { 'X-PJAX': 'true' },
        });

        const html = await response.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newMain = doc.getElementById('pjax-main');

        if (newMain) {
            main.innerHTML = newMain.innerHTML;
            if (updateHistory) history.pushState(null, '', url);
            updateActiveCategory(url);
            reinitContentAfterPjax();
        } else {
            window.location.href = url;
        }
    } catch (error) {
        console.error('PJAX error:', error);
        window.location.href = url;
    } finally {
        main.style.opacity = '';
    }
}

function updateActiveCategory(url) {
    const urlObj = new URL(url);
    const path = urlObj.pathname;

    document.querySelectorAll('.header-category-link, .mobile-nav-link').forEach((link) => {
        let linkPath;
        try {
            linkPath = new URL(link.href).pathname;
        } catch (_) {
            return;
        }
        link.classList.toggle('active', linkPath === path);
    });
}

function reinitContentAfterPjax() {
    initLiveSearch();
    initAddToCart();
    initAutoHideFlash();
}

function initLiveSearch() {
    const searchInput = document.getElementById('product-search-input');
    if (!searchInput) return;

    searchInput.removeEventListener('input', handleSearchInput);
    searchInput.addEventListener('input', handleSearchInput);
}

function handleSearchInput(e) {
    const query = e.target.value.trim();

    clearTimeout(liveSearchDebounce);
    liveSearchDebounce = setTimeout(() => {
        performSearch(query);
    }, 250);
}

async function performSearch(query) {
    if (!query) {
        pjaxLoad(location.pathname);
        return;
    }

    const form = document.getElementById('product-search-form');
    const category = form ? form.dataset.category || '' : '';

    const params = new URLSearchParams();
    params.set('q', query);
    if (category) params.set('category', category);

    try {
        const response = await fetch(`/api/products/search?${params.toString()}`);
        if (!response.ok) throw new Error('Search request failed');
        const products = await response.json();
        renderProducts(products, query);
    } catch (error) {
        console.error('Live search error:', error);
    }
}

function renderProducts(products, query) {
    const productsGrid = document.getElementById('all-products-grid');
    const productsTitle = document.getElementById('all-products-title');
    const featuredSection = document.getElementById('featured-products-section');
    const noProductsMessage = document.getElementById('no-products-message');
    const pagination = document.getElementById('all-products-pagination');
    const template = document.getElementById('product-card-template');

    if (!productsGrid || !template) return;

    if (featuredSection) featuredSection.style.display = 'none';
    if (pagination) pagination.style.display = 'none';

    if (productsTitle) {
        productsTitle.textContent = `Search results for "${query}"`;
        productsTitle.style.marginTop = '0';
    }

    productsGrid.innerHTML = '';

    if (products.length === 0) {
        productsGrid.style.display = 'none';
        if (noProductsMessage) noProductsMessage.style.display = 'block';
        return;
    }

    productsGrid.style.display = '';
    if (noProductsMessage) noProductsMessage.style.display = 'none';

    products.forEach((product) => {
        const clone = template.content.cloneNode(true);
        const link = clone.querySelector('.product-card-link');
        const img = clone.querySelector('.product-card-img');
        const placeholder = clone.querySelector('.product-card-img-placeholder');
        const name = clone.querySelector('.product-card-name');
        const description = clone.querySelector('.product-card-description');
        const price = clone.querySelector('.product-card-price');
        const stock = clone.querySelector('.product-card-stock');

        link.href = `/product/${product.slug}`;

        if (product.image) {
            img.src = product.image;
            img.alt = product.name;
            img.style.display = '';
            placeholder.style.display = 'none';
        } else {
            img.style.display = 'none';
            placeholder.style.display = '';
            placeholder.textContent = product.name;
        }

        name.textContent = product.name;
        description.textContent = product.description
            ? product.description.length > 80
                ? product.description.substring(0, 80) + '...'
                : product.description
            : '';
        price.textContent = `$${parseFloat(product.price).toFixed(2)}`;

        stock.textContent = `${product.quantity} in stock`;
        stock.classList.add(
            product.stock_status === 'in-stock'
                ? 'badge-success'
                : product.stock_status === 'low-stock'
                    ? 'badge-warning'
                    : 'badge-danger'
        );

        productsGrid.appendChild(clone);
    });
}

function initAddToCart() {
    const forms = document.querySelectorAll('.add-to-cart-form');
    if (forms.length === 0) return;

    forms.forEach((form) => {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalHtml = submitBtn ? submitBtn.innerHTML : '';

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Adding...';
            }

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.message, 'success');
                    updateCartCount(data.cart_count);
                    refreshCartSidebar();
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Add to cart error:', error);
                form.submit();
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                }
            }
        });
    });
}

function initRemoveFromCart() {
    const forms = document.querySelectorAll('.cart-remove-form');
    if (forms.length === 0) return;

    forms.forEach((form) => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.message, 'success');
                    updateCartCount(data.cart_count);
                    refreshCartSidebar();
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Remove from cart error:', error);
                form.submit();
            }
        });
    });
}

function initAutoHideFlash() {
    const alerts = document.querySelectorAll('.alert-success, .alert-error, .alert-info');
    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 400);
        }, 4000);
    });
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    if (!toast || !toastMessage) return;

    toastMessage.textContent = message;
    toast.classList.remove('toast-success', 'toast-error');
    toast.classList.add(type === 'success' ? 'toast-success' : 'toast-error');
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

function updateCartCount(count) {
    const badge = document.getElementById('header-cart-count');
    if (!badge) return;

    badge.textContent = count;
    badge.style.display = count > 0 ? 'inline-flex' : 'none';
}

function initCartSidebar() {
    const toggle = document.getElementById('cart-toggle');
    const overlay = document.getElementById('cart-overlay');
    const sidebar = document.getElementById('cart-sidebar');

    if (!toggle || !sidebar) return;

    const open = () => {
        sidebar.classList.add('open');
        if (overlay) overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    const closeSidebar = () => {
        sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
    };

    toggle.addEventListener('click', open);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    sidebar.addEventListener('click', (e) => {
        if (e.target.closest('#cart-sidebar-close') || e.target.closest('.continue-shopping')) {
            closeSidebar();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });
}

async function refreshCartSidebar() {
    const sidebar = document.getElementById('cart-sidebar');
    if (!sidebar) return;

    try {
        const response = await fetch('/api/cart/sidebar');
        if (!response.ok) throw new Error('Cart refresh failed');
        const html = await response.text();

        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newSidebar = doc.getElementById('cart-sidebar');

        if (newSidebar) {
            sidebar.innerHTML = newSidebar.innerHTML;
            initRemoveFromCart();
        }
    } catch (error) {
        console.error('Cart sidebar refresh error:', error);
    }
}
