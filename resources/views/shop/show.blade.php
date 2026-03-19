@extends('layouts.app')
@section('title', $product->name)

@push('styles')
<style>
    /* Breadcrumb */
    .breadcrumb { background: none; padding: 0; margin-bottom: 18px; font-size: .83rem; }
    .breadcrumb-item a { color: #740A03; text-decoration: none; }
    .breadcrumb-item a:hover { color: #C3110C; }
    .breadcrumb-item.active { color: #888; }
    .breadcrumb-item + .breadcrumb-item::before { color: #bbb; }

    /* Product main section */
    .product-image-wrap {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(40,9,5,.13);
        background: #f5eeec;
        aspect-ratio: 1;
        display: flex; align-items: center; justify-content: center;
    }
    .product-image-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .product-image-placeholder { color: #c9a09a; font-size: 5rem; }

    .product-info { padding-left: 10px; }

    .product-category-tag {
        display: inline-block;
        background: #f5eeec;
        color: #740A03;
        border: 1px solid #e0b0ad;
        border-radius: 20px;
        padding: 2px 12px;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .03em;
        margin-bottom: 10px;
    }

    .product-title { font-size: 1.8rem; font-weight: 800; color: #280905; line-height: 1.2; margin-bottom: 14px; }

    /* Rating row */
    .rating-row { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
    .stars i { color: #E6501B; font-size: .95rem; }
    .stars i.text-muted { color: #ddd !important; }
    .rating-score { font-weight: 700; color: #280905; font-size: .9rem; }
    .review-count { color: #888; font-size: .85rem; }

    .product-price {
        font-size: 2rem;
        font-weight: 800;
        color: #C3110C;
        margin-bottom: 16px;
        line-height: 1;
    }

    .product-description { color: #555; font-size: .92rem; line-height: 1.7; margin-bottom: 20px; }

    /* Stock badge */
    .stock-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: .82rem;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .stock-in  { background: #d1e7dd; color: #0a3622; }
    .stock-out { background: #f8d7da; color: #58151c; }

    /* Qty + Add to cart */
    .purchase-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .qty-wrap { display: flex; align-items: center; border: 2px solid #e0b0ad; border-radius: 6px; overflow: hidden; }
    .qty-wrap button {
        background: #f5eeec; border: none;
        width: 38px; height: 42px;
        font-size: 1.1rem; font-weight: 700;
        color: #740A03; cursor: pointer;
        transition: background .15s;
    }
    .qty-wrap button:hover { background: #e0b0ad; }
    .qty-wrap input {
        width: 52px; height: 42px;
        border: none; border-left: 1px solid #e0b0ad; border-right: 1px solid #e0b0ad;
        text-align: center; font-size: .95rem; font-weight: 700;
        color: #280905; background: #fff;
    }
    .qty-wrap input:focus { outline: none; }
    .btn-add-cart-lg {
        flex: 1; min-width: 160px;
        padding: 11px 20px;
        background: #C3110C;
        color: #fff; border: none;
        border-radius: 6px;
        font-weight: 700; font-size: .95rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: background .2s;
    }
    .btn-add-cart-lg:hover { background: #740A03; }
    .btn-add-cart-lg:disabled { background: #C3110C; opacity: .8; cursor: not-allowed; }

    /* Divider */
    .product-divider { border: none; border-top: 1px solid #f0e8e7; margin: 28px 0; }

    /* Related products */
    .section-heading {
        font-size: 1.1rem; font-weight: 800; color: #280905;
        border-left: 4px solid #C3110C; padding-left: 10px;
        margin-bottom: 18px;
    }
    .related-card {
        border: none; border-radius: 8px;
        box-shadow: 0 2px 10px rgba(40,9,5,.09);
        overflow: hidden; transition: transform .15s, box-shadow .15s;
        height: 100%;
    }
    .related-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(40,9,5,.15); }
    .related-card img { width: 100%; height: 140px; object-fit: cover; }
    .related-card-body { padding: 10px 12px; }
    .related-card-name { font-size: .85rem; font-weight: 600; color: #280905; margin-bottom: 4px; text-decoration: none; display: block; }
    .related-card-name:hover { color: #C3110C; }
    .related-card-price { font-size: .9rem; font-weight: 700; color: #C3110C; }

    /* Reviews section */
    .reviews-wrap {
        border: none; border-radius: 8px;
        box-shadow: 0 2px 12px rgba(40,9,5,.09);
        overflow: hidden;
    }
    .reviews-header {
        background: #280905; color: #fff;
        padding: 12px 18px; font-weight: 700;
        font-size: .85rem; letter-spacing: .04em; text-transform: uppercase;
        display: flex; align-items: center; gap: 8px;
    }
    .reviews-header i { color: #E6501B; }
    .review-item {
        padding: 14px 18px;
        border-bottom: 1px solid #f0e8e7;
    }
    .review-item:last-child { border-bottom: none; }
    .review-author { font-weight: 700; color: #280905; font-size: .9rem; }
    .review-date { color: #aaa; font-size: .78rem; }
    .review-stars i { color: #E6501B; font-size: .8rem; }
    .review-stars i.empty { color: #ddd; }
    .review-body { font-size: .88rem; color: #444; margin-top: 6px; line-height: 1.6; }
    .no-reviews { padding: 24px 18px; color: #aaa; font-size: .9rem; font-style: italic; }

    /* Write review card */
    .write-review-card {
        border: none; border-radius: 8px;
        box-shadow: 0 2px 12px rgba(40,9,5,.09);
        overflow: hidden;
    }
    .write-review-header {
        background: #280905; color: #fff;
        padding: 12px 18px; font-weight: 700;
        font-size: .85rem; letter-spacing: .04em; text-transform: uppercase;
        display: flex; align-items: center; gap: 8px;
    }
    .write-review-header i { color: #E6501B; }
    .write-review-body { padding: 18px; }
    .star-select i { font-size: 1.5rem; color: #ddd; cursor: pointer; transition: color .1s; }
    .star-select i.active, .star-select i:hover { color: #E6501B; }
    .review-textarea {
        width: 100%; padding: 10px 12px;
        border: 1.5px solid #e0d0cf; border-radius: 6px;
        font-size: .88rem; resize: vertical; min-height: 90px;
        transition: border-color .2s;
    }
    .review-textarea:focus { border-color: #C3110C; outline: none; }
    .btn-submit-review {
        width: 100%; padding: 10px;
        background: #C3110C; color: #fff;
        border: none; border-radius: 6px;
        font-weight: 700; font-size: .9rem;
        cursor: pointer; transition: background .2s;
        display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .btn-submit-review:hover { background: #740A03; }
    .review-error {
        background: #fdf0f0; border: 1px solid #e0b0ad;
        border-radius: 5px; padding: 8px 12px;
        font-size: .82rem; color: #740A03; margin-bottom: 10px;
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('shop.index', ['categories[]' => $product->category_id]) }}">{{ $product->category->name }}</a>
        </li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

{{-- Product main --}}
<div class="row mb-4" style="row-gap:24px;">
    <div class="col-md-5">
        <div class="product-image-wrap">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <img src="https://picsum.photos/seed/{{ $product->id }}/600/500" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
            @endif
        </div>
    </div>

    <div class="col-md-7 product-info">
        <span class="product-category-tag">
            <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
        </span>

        <h1 class="product-title">{{ $product->name }}</h1>

        @php $avg = round($product->reviews->avg('rating'), 1); @endphp
        <div class="rating-row">
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= round($avg) ? '' : ' text-muted' }}"></i>
                @endfor
            </div>
            <span class="rating-score">{{ $avg > 0 ? $avg : '—' }}</span>
            <span class="review-count">(<span id="reviewCount">{{ $product->reviews->count() }}</span> review{{ $product->reviews->count() == 1 ? '' : 's' }})</span>
        </div>

        <div class="product-price">${{ number_format($product->price, 2) }}</div>

        <p class="product-description">{{ $product->description }}</p>

        <div>
            @if($product->stock > 0)
                <span class="stock-badge stock-in">
                    <i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }} available)
                </span>
            @else
                <span class="stock-badge stock-out">
                    <i class="fas fa-times-circle"></i> Out of Stock
                </span>
            @endif
        </div>

        @if($product->stock > 0)
        <div class="purchase-row">
            <div class="qty-wrap">
                <button type="button" id="qtyMinus">−</button>
                <input type="number" id="qtyInput" value="1" min="1" max="{{ $product->stock }}">
                <button type="button" id="qtyPlus">+</button>
            </div>
            <button class="btn-add-cart-lg" id="addToCartBtn"
                    data-url="{{ route('cart.add', $product) }}">
                <i class="fas fa-cart-plus"></i> Add to Cart
            </button>
        </div>
        @endif
    </div>
</div>

<hr class="product-divider">

{{-- Related products --}}
@if($related->isNotEmpty())
<div class="mb-4">
    <div class="section-heading">Related Products</div>
    <div class="row g-3">
        @foreach($related as $rel)
        <div class="col-6 col-md-3">
            <div class="related-card">
                <a href="{{ route('shop.show', $rel) }}">
                    @if($rel->image)
                        <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}">
                    @else
                        <img src="https://picsum.photos/seed/{{ $rel->id }}/300/140" alt="{{ $rel->name }}" style="width:100%;height:140px;object-fit:cover;display:block;">
                    @endif
                </a>
                <div class="related-card-body">
                    <a href="{{ route('shop.show', $rel) }}" class="related-card-name">{{ $rel->name }}</a>
                    <div class="related-card-price">${{ number_format($rel->price, 2) }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<hr class="product-divider">
@endif

{{-- Reviews --}}
<div class="row g-4">
    <div class="col-md-8">
        <div class="reviews-wrap">
            <div class="reviews-header">
                <i class="fas fa-star"></i>
                Customer Reviews
                <span style="margin-left:auto; font-weight:400; font-size:.8rem; color:#c9a09a;">
                    {{ $product->reviews->count() }} review{{ $product->reviews->count() == 1 ? '' : 's' }}
                </span>
            </div>
            <div id="reviewsList">
                @forelse($product->reviews as $review)
                <div class="review-item">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="review-author">{{ $review->user->name }}</span>
                        <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i > $review->rating ? ' empty' : '' }}"></i>
                        @endfor
                    </div>
                    <div class="review-body">{{ $review->body }}</div>
                </div>
                @empty
                <div class="no-reviews" id="noReviewsMsg">
                    <i class="fas fa-comment-slash me-2"></i>No reviews yet. Be the first to share your experience!
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @auth
    <div class="col-md-4">
        <div class="write-review-card">
            <div class="write-review-header">
                <i class="fas fa-pen"></i> Write a Review
            </div>
            <div class="write-review-body">
                <form id="reviewForm" data-url="{{ route('reviews.store', $product) }}">
                    @csrf
                    <div class="mb-3">
                        <div style="font-size:.8rem;font-weight:600;color:#740A03;margin-bottom:8px;text-transform:uppercase;letter-spacing:.04em;">Your Rating</div>
                        <div class="star-select d-flex gap-1" id="starRating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="far fa-star" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="0">
                    </div>
                    <div class="mb-3">
                        <div style="font-size:.8rem;font-weight:600;color:#740A03;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">Your Review</div>
                        <textarea name="body" class="review-textarea"
                                  placeholder="Share your experience with this product..."
                                  required minlength="10"></textarea>
                    </div>
                    <div id="reviewError" class="review-error" style="display:none;"></div>
                    <button type="submit" class="btn-submit-review">
                        <i class="fas fa-paper-plane"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="col-md-4">
        <div class="write-review-card">
            <div class="write-review-header">
                <i class="fas fa-pen"></i> Write a Review
            </div>
            <div class="write-review-body text-center py-3">
                <p style="color:#888;font-size:.88rem;margin-bottom:14px;">Login to leave a review for this product.</p>
                <a href="{{ route('login') }}" style="display:inline-block;padding:8px 20px;background:#C3110C;color:#fff;border-radius:5px;text-decoration:none;font-weight:600;font-size:.875rem;">
                    <i class="fas fa-sign-in-alt me-1"></i> Login
                </a>
            </div>
        </div>
    </div>
    @endauth
</div>

{{-- Toast --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="cartToast" class="toast align-items-center text-white border-0"
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
// Quantity +/-
$('#qtyMinus').on('click', function () {
    const input = $('#qtyInput');
    if (parseInt(input.val()) > 1) input.val(parseInt(input.val()) - 1);
});
$('#qtyPlus').on('click', function () {
    const input = $('#qtyInput');
    if (parseInt(input.val()) < parseInt(input.attr('max'))) input.val(parseInt(input.val()) + 1);
});

// Add to cart
$('#addToCartBtn').on('click', function () {
    const btn = $(this);
    const qty = parseInt($('#qtyInput').val());
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Adding...');
    $.post(btn.data('url'), { _token: '{{ csrf_token() }}', quantity: qty }, function (res) {
        if (res.success) {
            $('#cartCount').text(res.cart_count).show();
            $('#toastMessage').text(res.message);
            new bootstrap.Toast(document.getElementById('cartToast')).show();
        }
    }).always(function () {
        btn.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart');
    });
});

// Star rating
let selectedRating = 0;
$('#starRating i').on('mouseover', function () {
    const val = $(this).data('value');
    $('#starRating i').each(function () {
        const active = $(this).data('value') <= val;
        $(this).toggleClass('fas active', active).toggleClass('far', !active);
    });
}).on('mouseleave', function () {
    $('#starRating i').each(function () {
        const active = $(this).data('value') <= selectedRating;
        $(this).toggleClass('fas active', active).toggleClass('far', !active);
    });
}).on('click', function () {
    selectedRating = $(this).data('value');
    $('#ratingInput').val(selectedRating);
});

// Submit review
$('#reviewForm').on('submit', function (e) {
    e.preventDefault();
    if (selectedRating === 0) {
        $('#reviewError').text('Please select a star rating.').show();
        return;
    }
    $.post($(this).data('url'), $(this).serialize(), function (res) {
        if (res.success) {
            $('#noReviewsMsg').remove();
            const stars = Array.from({length: 5}, (_, i) =>
                `<i class="fas fa-star${i >= res.review.rating ? ' empty' : ''}"></i>`).join('');
            $('#reviewsList').prepend(`
                <div class="review-item">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="review-author">${res.review.user}</span>
                        <span class="review-date">${res.review.created_at}</span>
                    </div>
                    <div class="review-stars">${stars}</div>
                    <div class="review-body">${res.review.body}</div>
                </div>`);
            $('#reviewCount').text(res.total);
            $('#reviewForm')[0].reset();
            selectedRating = 0;
            $('#starRating i').removeClass('fas active').addClass('far');
            $('#reviewError').hide();
        }
    }).fail(function (xhr) {
        $('#reviewError').text(xhr.responseJSON?.message ?? 'Error submitting review.').show();
    });
});
</script>
@endpush
