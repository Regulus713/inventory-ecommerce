import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    initMobileNavigation();
    initLiveSearch();
    initAddToCart();
    initAutoHideFlash();
});

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

function initLiveSearch() {
    const searchInput = document.getElementById('product-search-input');
    const searchForm = document.getElementById('product-search-form');
    const productsGrid = document.getElementById('all-products-grid');
    const productsTitle = document.getElementById('all-products-title');
    const featuredSection = document.getElementById('featured-products-section');
    const noProductsMessage = document.getElementById('no-products-message');
    const pagination = document.getElementById('all-products-pagination');
    const template = document.getElementById('product-card-template');

    if (!searchInput || !searchForm || !productsGrid || !template) return;

    let debounceTimer;
    const category = searchForm.dataset.category || '';

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            performSearch(query);
        }, 250);
    });

    async function performSearch(query) {
        if (!query) {
            window.location.href = window.location.pathname;
            return;
        }

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
}

function initAddToCart() {
    const form = document.querySelector('.add-to-cart-form');
    if (!form) return;

    const submitBtn = form.querySelector('button[type="submit"]');

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
            } else {
                showToast(data.message, 'error');
            }
        } catch (error) {
            console.error('Add to cart error:', error);
            form.submit();
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg> Add to Cart`;
            }
        }
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
