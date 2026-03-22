@extends('layouts.app')
@section('title', 'Shop')

@push('styles')
<style>
    /* ── Filter sidebar ─────────────────────────── */
    .filter-card {
        border: none;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(40,9,5,.12);
    }
    .filter-card .filter-header {
        background: #280905;
        color: #fff;
        padding: 14px 18px;
        font-weight: 700;
        font-size: .95rem;
        letter-spacing: .03em;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .filter-section {
        padding: 16px 18px;
        border-bottom: 1px solid #f0e8e7;
    }
    .filter-section:last-child { border-bottom: none; }
    .filter-section-title {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #740A03;
        margin-bottom: 10px;
    }

    .filter-check {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 0;
        cursor: pointer;
        font-size: .9rem;
        color: #333;
        user-select: none;
    }
    .filter-check input[type="checkbox"] {
        width: 16px; height: 16px;
        accent-color: #C3110C;
        cursor: pointer;
        flex-shrink: 0;
    }
    .filter-check:hover { color: #C3110C; }

    .price-input {
        width: 100%;
        padding: 5px 10px;
        font-size: .875rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        outline: none;
        transition: border-color .2s;
    }
    .price-input:focus { border-color: #C3110C; box-shadow: 0 0 0 2px rgba(195,17,12,.15); }

    .btn-filter-apply {
        width: 100%;
        padding: 8px;
        background: #C3110C;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: .875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-filter-apply:hover { background: #740A03; }

    .btn-filter-clear {
        width: 100%;
        padding: 7px;
        background: transparent;
        color: #740A03;
        border: 1px solid #740A03;
        border-radius: 4px;
        font-size: .875rem;
        cursor: pointer;
        margin-top: 6px;
        transition: all .2s;
    }
    .btn-filter-clear:hover { background: #740A03; color: #fff; }

    /* ── Search + sort toolbar ──────────────────── */
    .shop-toolbar {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        background: linear-gradient(135deg, #280905, #740A03);
        border-bottom: 3px solid #C3110C;
        border-radius: 8px;
        padding: 10px 14px;
        box-shadow: 0 2px 12px rgba(40,9,5,.2);
    }
    .shop-search-wrap {
        flex: 1;
        min-width: 180px;
        display: flex;
    }
    .shop-search-wrap .shop-search-input {
        flex: 1;
        padding: 7px 14px;
        font-size: .875rem;
        border: 1px solid rgba(255,255,255,.2);
        border-right: none;
        border-radius: 20px 0 0 20px;
        outline: none;
        transition: background .2s, border-color .2s;
        background: rgba(255,255,255,.1);
        color: #fff;
    }
    .shop-search-wrap .shop-search-input::placeholder { color: rgba(255,255,255,.5); }
    .shop-search-wrap .shop-search-input:focus {
        background: rgba(255,255,255,.18);
        border-color: #E6501B;
        box-shadow: none;
    }
    .shop-search-wrap .shop-search-btn {
        background: #C3110C;
        border: 1px solid #C3110C;
        color: #fff;
        border-radius: 0 20px 20px 0;
        padding: 0 14px;
        cursor: pointer;
        font-size: .85rem;
        transition: background .2s;
        flex-shrink: 0;
    }
    .shop-search-wrap .shop-search-btn:hover { background: #E6501B; border-color: #E6501B; }
    .toolbar-divider {
        width: 1px;
        height: 28px;
        background: rgba(255,255,255,.2);
        flex-shrink: 0;
    }
    .sort-label {
        font-size: .78rem;
        font-weight: 600;
        color: #f5d5c8;
        text-transform: uppercase;
        letter-spacing: .05em;
        white-space: nowrap;
        flex-shrink: 0;
    }
    /* ── Custom sort dropdown ───────────────────── */
    .sort-dropdown { position: relative; flex-shrink: 0; }
    .sort-dropdown-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        font-size: .875rem;
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 20px;
        background: rgba(255,255,255,.1);
        color: #fff;
        font-weight: 500;
        cursor: pointer;
        white-space: nowrap;
        transition: background .2s, border-color .2s;
        user-select: none;
    }
    .sort-dropdown-btn:hover { background: rgba(255,255,255,.18); border-color: rgba(255,255,255,.4); }
    .sort-dropdown-btn .sort-chevron { font-size: .7rem; opacity: .7; transition: transform .2s; }
    .sort-dropdown.open .sort-chevron { transform: rotate(180deg); }
    .sort-dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        min-width: 180px;
        background: #280905;
        border: none;
        border-top: 3px solid #C3110C;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 8px 24px rgba(40,9,5,.4);
        z-index: 9999;
        overflow: hidden;
    }
    .sort-dropdown.open .sort-dropdown-menu { display: block; }
    .sort-dropdown-item {
        display: block;
        padding: 10px 16px;
        font-size: .875rem;
        color: #f5d5c8;
        cursor: pointer;
        transition: background .15s, color .15s;
        border-bottom: 1px solid #3d0c07;
    }
    .sort-dropdown-item:last-child { border-bottom: none; }
    .sort-dropdown-item:hover { background: #740A03; color: #fff; }
    .sort-dropdown-item.active { background: #C3110C; color: #fff; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="row">
    {{-- ── Sidebar filters ──────────────────────── --}}
    <div class="col-md-3 mb-4">
        <div class="filter-card">
            <div class="filter-header">
                <i class="fas fa-sliders-h"></i> Filters
            </div>

            {{-- Categories --}}
            <div class="filter-section">
                <div class="filter-section-title">Category</div>
                @foreach($categories as $cat)
                <label class="filter-check">
                    <input type="checkbox" class="filter-checkbox" name="categories[]"
                           value="{{ $cat->id }}"
                           {{ in_array($cat->id, (array) request('categories', [])) ? 'checked' : '' }}>
                    {{ $cat->name }}
                </label>
                @endforeach
            </div>

            {{-- Price range --}}
            <div class="filter-section">
                <div class="filter-section-title">Price Range</div>
                <div class="d-flex align-items-center gap-2">
                    <input type="number" id="priceMin" class="price-input" placeholder="Min $"
                           min="0" step="1" value="{{ request('price_min') }}">
                    <span style="color:#aaa; font-size:.8rem;">—</span>
                    <input type="number" id="priceMax" class="price-input" placeholder="Max $"
                           min="0" step="1" value="{{ request('price_max') }}">
                </div>
            </div>

            {{-- Buttons --}}
            <div class="filter-section">
                <button class="btn-filter-apply" id="applyFilters">
                    <i class="fas fa-search me-1"></i> Apply Filters
                </button>
                <button class="btn-filter-clear" id="clearFilters">
                    <i class="fas fa-times me-1"></i> Clear All
                </button>
            </div>
        </div>
    </div>

    {{-- ── Product grid ─────────────────────────── --}}
    <div class="col-md-9">

        {{-- Search + sort toolbar --}}
        <div class="shop-toolbar">
            <div class="shop-search-wrap">
                <input type="text" id="shopSearch" class="shop-search-input"
                       placeholder="Search products…"
                       value="{{ request('search') }}">
                <button type="button" class="shop-search-btn" id="shopSearchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="toolbar-divider"></div>
            <div class="sort-dropdown" id="sortDropdown">
                @php
                    $sortLabels = ['' => 'Name A–Z', 'price_asc' => 'Price: Low → High', 'price_desc' => 'Price: High → Low', 'newest' => 'Newest First'];
                    $currentSort = request('sort', '');
                @endphp
                <button type="button" class="sort-dropdown-btn" id="sortDropdownBtn">
                    <i class="fas fa-sort-amount-down" style="font-size:.8rem;opacity:.8;"></i>
                    <span id="sortLabel">{{ $sortLabels[$currentSort] }}</span>
                    <i class="fas fa-chevron-down sort-chevron"></i>
                </button>
                <div class="sort-dropdown-menu">
                    @foreach($sortLabels as $val => $label)
                    <div class="sort-dropdown-item {{ $currentSort === $val ? 'active' : '' }}"
                         data-value="{{ $val }}">{{ $label }}</div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <small class="text-muted" id="productCount">{{ $products->total() }} product(s) found</small>
        </div>

        <div class="row" id="productGrid">
            @include('partials.product-grid')
        </div>

        <div id="paginationArea">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>

{{-- Toast notification --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="cartToast" class="toast align-items-center text-white border-0" role="alert"
         style="background:#C3110C;">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const BASE_URL = '{{ route('shop.index') }}';

function getFilters() {
    const params = new URLSearchParams();

    const search = $('#shopSearch').val().trim();
    if (search) params.set('search', search);

    $('input.filter-checkbox:checked').each(function () {
        params.append('categories[]', $(this).val());
    });

    const priceMin = $('#priceMin').val();
    const priceMax = $('#priceMax').val();
    if (priceMin) params.set('price_min', priceMin);
    if (priceMax) params.set('price_max', priceMax);

    const sort = $('#sortDropdown').data('value') || '';
    if (sort) params.set('sort', sort);

    return params;
}

function loadProducts(params) {
    $('#productGrid').html(
        '<div class="col-12 text-center py-5">' +
        '<div class="spinner-border" style="color:#C3110C;"></div>' +
        '</div>'
    );

    $.get(BASE_URL + '?' + params.toString(), function (res) {
        $('#productGrid').html(res.html);
        $('#paginationArea').html(res.pagination);
        $('#productCount').text(res.total + ' product(s) found');
        history.pushState({}, '', '?' + params.toString());
    });
}

// Search input — debounced as-you-type
let searchTimer;
$('#shopSearch').on('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => loadProducts(getFilters()), 350);
});

// Search — trigger on Enter or button click
$('#shopSearch').on('keydown', function (e) {
    if (e.key === 'Enter') { clearTimeout(searchTimer); loadProducts(getFilters()); }
});
$('#shopSearchBtn').on('click', function () {
    clearTimeout(searchTimer); loadProducts(getFilters());
});

// Apply filters button
$('#applyFilters').on('click', function () {
    loadProducts(getFilters());
});

// Price inputs — trigger on Enter key
$('#priceMin, #priceMax').on('keydown', function (e) {
    if (e.key === 'Enter') loadProducts(getFilters());
});

// Custom sort dropdown
$('#sortDropdownBtn').on('click', function (e) {
    e.stopPropagation();
    $('#sortDropdown').toggleClass('open');
});
$(document).on('click', function () {
    $('#sortDropdown').removeClass('open');
});
$(document).on('click', '.sort-dropdown-item', function () {
    const val   = $(this).data('value');
    const label = $(this).text();
    $('#sortDropdown').data('value', val).removeClass('open');
    $('#sortLabel').text(label);
    $('.sort-dropdown-item').removeClass('active');
    $(this).addClass('active');
    loadProducts(getFilters());
});

// Clear all
$('#clearFilters').on('click', function () {
    $('#shopSearch').val('');
    $('#navSearchInput').val('');
    $('input.filter-checkbox').prop('checked', false);
    $('#priceMin').val('');
    $('#priceMax').val('');
    $('#sortDropdown').data('value', '');
    $('#sortLabel').text('Name A–Z');
    $('.sort-dropdown-item').removeClass('active').filter('[data-value=""]').addClass('active');
    loadProducts(new URLSearchParams());
});

// Intercept pagination links
$(document).on('click', '#paginationArea a', function (e) {
    e.preventDefault();
    const params = new URL($(this).attr('href')).searchParams;
    // Keep current search in input when paginating
    const currentSearch = $('#shopSearch').val().trim();
    if (currentSearch && !params.has('search')) params.set('search', currentSearch);
    loadProducts(params);
    window.scrollTo(0, 0);
});

// Add to cart
$(document).on('click', '.btn-add-cart', function () {
    const btn = $(this);
    const url = btn.data('url');

    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

    $.post(url, { _token: '{{ csrf_token() }}', quantity: 1 }, function (res) {
        if (res.success) {
            $('#cartCount').text(res.cart_count).show();
            $('#toastMessage').text(res.message);
            new bootstrap.Toast(document.getElementById('cartToast')).show();
        }
    }).always(function () {
        btn.prop('disabled', false).html('<i class="fas fa-cart-plus me-1"></i> Add to Cart');
    });
});
</script>
@endpush
