<aside class="cart-sidebar" id="cart-sidebar" aria-label="Shopping cart sidebar">
    <div class="cart-sidebar-header">
        <h2 class="cart-sidebar-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            Your Cart
        </h2>
        <button class="cart-sidebar-close" id="cart-sidebar-close" aria-label="Close cart sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>

    <div class="cart-sidebar-content" id="cart-sidebar-content">
        @if(count($cartItems) === 0)
            <div class="cart-sidebar-empty">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; color: var(--color-primary-400);"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <p>Your cart is empty</p>
                <button class="btn btn-secondary continue-shopping">Continue Shopping</button>
            </div>
        @else
            <div class="cart-sidebar-items">
                @foreach($cartItems as $item)
                    <div class="cart-sidebar-item" data-slug="{{ $item['product']->slug }}">
                        <div class="cart-sidebar-image">
                            @if($item['product']->image)
                                <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}">
                            @else
                                <span>{{ $item['product']->name[0] }}</span>
                            @endif
                        </div>
                        <div class="cart-sidebar-details">
                            <a href="{{ route('inventory.product', $item['product']->slug) }}" class="cart-sidebar-name">{{ $item['product']->name }}</a>
                            <div class="cart-sidebar-qty">Qty: {{ $item['quantity'] }}</div>
                            <div class="cart-sidebar-price">${{ number_format($item['subtotal'], 2) }}</div>
                        </div>
                        <form action="{{ route('cart.remove', $item['product']->slug) }}" method="POST" class="cart-sidebar-remove cart-remove-form" data-remove="true">
                            @csrf
                            <button type="submit" aria-label="Remove {{ $item['product']->name }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="cart-sidebar-footer">
                <div class="cart-sidebar-subtotal">
                    <span>Subtotal</span>
                    <span class="cart-sidebar-amount">${{ number_format($cartSubtotal, 2) }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="width: 100%;">Checkout</a>
                <a href="{{ route('cart.index') }}" class="btn btn-secondary" style="width: 100%;">View Cart</a>
            </div>
        @endif
    </div>
</aside>
