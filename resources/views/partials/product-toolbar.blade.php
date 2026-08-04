<div class="product-toolbar">
    <div class="product-sort">
        <label for="product-sort">Sort by</label>
        <select id="product-sort" class="form-select" onchange="window.location.href = this.value;">
            @php($sortOptions = ['newest' => 'Newest', 'oldest' => 'Oldest', 'price-asc' => 'Price: Low to High', 'price-desc' => 'Price: High to Low', 'name-asc' => 'Name: A-Z', 'name-desc' => 'Name: Z-A'])
            @foreach($sortOptions as $value => $label)
                <option value="{{ request()->fullUrlWithQuery(['sort' => $value]) }}" {{ $sort === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="product-view-toggle">
        <span class="product-view-label">View</span>
        <a href="{{ request()->fullUrlWithQuery(['view' => 'card']) }}" class="product-view-btn {{ $view === 'card' ? 'active' : '' }}" title="Card view" aria-label="Card view">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}" class="product-view-btn {{ $view === 'list' ? 'active' : '' }}" title="List view" aria-label="List view">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        </a>
    </div>
</div>
