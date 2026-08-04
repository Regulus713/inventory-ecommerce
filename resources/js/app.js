import './bootstrap';

// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const sidebar = document.querySelector('.app-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    if (menuBtn && sidebar) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            if (overlay) overlay.classList.toggle('open');
        });

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            });
        }
    }

    // Real-time product search
    initLiveSearch();
});

function initLiveSearch() {
    const searchInput = document.getElementById('product-search-input');
    const searchForm = document.getElementById('product-search-form');
    const productsGrid = document.getElementById('all-products-grid');
    const productsTitle = document.getElementById('all-products-title');
    const featuredSection = document.getElementById('featured-products-section');
    const noProductsMessage = document.getElementById('no-products-message');
    const pagination = document.getElementById('all-products-pagination');
    const template = document.getElementById('product-card-template');

    // Only enable live search on pages with the products grid and template
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
            // Reload the page to restore initial state when search is cleared
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
        // Hide featured products while searching
        if (featuredSection) featuredSection.style.display = 'none';
        if (pagination) pagination.style.display = 'none';

        // Update title
        if (productsTitle) {
            productsTitle.textContent = `Search results for "${query}"`;
            productsTitle.style.marginTop = '0';
        }

        // Clear grid
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
