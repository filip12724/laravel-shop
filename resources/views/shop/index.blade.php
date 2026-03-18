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

    /* Custom checkboxes in palette colour */
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

    /* Price inputs */
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

    /* Sort select */
    .filter-select {
        width: 100%;
        padding: 6px 10px;
        font-size: .875rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        outline: none;
        background: #fff;
        cursor: pointer;
    }
    .filter-select:focus { border-color: #C3110C; box-shadow: 0 0 0 2px rgba(195,17,12,.15); }

    /* Buttons */
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

    /* Active filter badges */
    .active-filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f5e8e7;
        color: #740A03;
        border: 1px solid #e0b0ad;
        border-radius: 20px;
        padding: 2px 10px;
        font-size: .78rem;
        font-weight: 500;
    }
    .active-filter-tag button {
        background: none;
        border: none;
        color: #C3110C;
        cursor: pointer;
        padding: 0;
        font-size: .85rem;
        line-height: 1;
    }
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

            {{-- Sort --}}
            <div class="filter-section">
                <div class="filter-section-title">Sort By</div>
                <select id="sortSelect" class="filter-select">
                    <option value=""       {{ !request('sort') ? 'selected' : '' }}>Name A–Z</option>
                    <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>Price: Low → High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                    <option value="newest"     {{ request('sort') == 'newest'     ? 'selected' : '' }}>Newest First</option>
                </select>
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
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h5 class="mb-0">Products</h5>
                <small class="text-muted" id="productCount">{{ $products->total() }} product(s) found</small>
            </div>
            <div class="d-flex flex-wrap gap-1" id="activeFilterTags">
                @if(request('search'))
                    <span class="active-filter-tag">Search: "{{ request('search') }}"</span>
                @endif
            </div>
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

    // Keep search term
    const search = new URLSearchParams(location.search).get('search');
    if (search) params.set('search', search);

    // Multiple categories
    $('input.filter-checkbox:checked').each(function () {
        params.append('categories[]', $(this).val());
    });

    // Price range
    const priceMin = $('#priceMin').val();
    const priceMax = $('#priceMax').val();
    if (priceMin) params.set('price_min', priceMin);
    if (priceMax) params.set('price_max', priceMax);

    // Sort
    const sort = $('#sortSelect').val();
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

// Apply filters button
$('#applyFilters').on('click', function () {
    loadProducts(getFilters());
});

// Price inputs — trigger on Enter key
$('#priceMin, #priceMax').on('keydown', function (e) {
    if (e.key === 'Enter') loadProducts(getFilters());
});

// Sort — instant change
$('#sortSelect').on('change', function () {
    loadProducts(getFilters());
});

// Clear all
$('#clearFilters').on('click', function () {
    $('input.filter-checkbox').prop('checked', false);
    $('#priceMin').val('');
    $('#priceMax').val('');
    $('#sortSelect').val('');
    loadProducts(new URLSearchParams());
});

// Intercept pagination links
$(document).on('click', '#paginationArea a', function (e) {
    e.preventDefault();
    const params = new URL($(this).attr('href')).searchParams;
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
