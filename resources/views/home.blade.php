@extends('layouts.app')
@section('title', config('app.name') . ' — Home')

@push('styles')
<style>
    /* ── Hero ─────────────────────────────────────── */
    .hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #1a0503 0%, #280905 40%, #740A03 100%);
        border-radius: 12px;
        padding: 72px 48px;
        margin-bottom: 48px;
        color: #fff;
    }
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 80% 50%, rgba(195,17,12,.25) 0%, transparent 70%),
            radial-gradient(ellipse 40% 60% at 15% 80%, rgba(230,80,27,.15) 0%, transparent 60%);
        pointer-events: none;
    }
    /* floating orbs */
    .hero-orb {
        position: absolute;
        border-radius: 50%;
        opacity: .08;
        animation: floatOrb 8s ease-in-out infinite;
    }
    .hero-orb-1 { width:320px;height:320px; background:#C3110C; top:-80px; right:-60px; animation-delay:0s; }
    .hero-orb-2 { width:180px;height:180px; background:#E6501B; bottom:-40px; right:200px; animation-delay:-3s; }
    .hero-orb-3 { width:100px;height:100px; background:#fff; bottom:30px; left:40px; animation-delay:-5s; }
    @keyframes floatOrb {
        0%, 100% { transform: translateY(0) scale(1); }
        50%       { transform: translateY(-18px) scale(1.05); }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 20px;
        padding: 5px 14px;
        font-size: .8rem;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #f5d5c8;
        margin-bottom: 18px;
    }
    .hero h1 {
        font-size: clamp(2rem, 5vw, 3.2rem);
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 18px;
        letter-spacing: -.5px;
    }
    .hero h1 span { color: #E6501B; }
    .hero p {
        font-size: 1.05rem;
        color: #f5d5c8;
        max-width: 500px;
        margin-bottom: 28px;
        line-height: 1.65;
    }
    .hero .btn-hero-primary {
        background: #C3110C;
        border: none;
        color: #fff;
        padding: 13px 32px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background .2s, transform .2s, box-shadow .2s;
        box-shadow: 0 4px 18px rgba(195,17,12,.45);
    }
    .hero .btn-hero-primary:hover {
        background: #E6501B;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(230,80,27,.45);
        color: #fff;
    }
    .hero .btn-hero-outline {
        background: transparent;
        border: 2px solid rgba(255,255,255,.35);
        color: #fff;
        padding: 11px 28px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background .2s, border-color .2s;
    }
    .hero .btn-hero-outline:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.6); color: #fff; }
    .hero-stats {
        display: flex;
        gap: 32px;
        margin-top: 36px;
        flex-wrap: wrap;
    }
    .hero-stat { text-align: center; }
    .hero-stat .num { font-size: 1.6rem; font-weight: 800; color: #fff; line-height: 1; }
    .hero-stat .lbl { font-size: .75rem; color: #c9a09a; text-transform: uppercase; letter-spacing: .06em; margin-top: 2px; }

    /* ── Perks strip ──────────────────────────────── */
    .perks-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1px;
        background: #e0ccc9;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 48px;
        box-shadow: 0 2px 12px rgba(40,9,5,.08);
    }
    .perk-item {
        background: #fff;
        padding: 22px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: background .2s;
    }
    .perk-item:hover { background: #fdf5f4; }
    .perk-icon {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, #280905, #740A03);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        color: #E6501B;
        font-size: 1.1rem;
    }
    .perk-title { font-weight: 700; font-size: .875rem; color: #280905; margin-bottom: 1px; }
    .perk-sub   { font-size: .78rem; color: #888; line-height: 1.3; }

    /* ── Section headings ─────────────────────────── */
    .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 8px;
    }
    .section-heading h2 {
        font-size: 1.4rem;
        font-weight: 800;
        color: #280905;
        margin: 0;
        border-left: 4px solid #C3110C;
        padding-left: 12px;
    }
    .section-heading a {
        font-size: .875rem;
        color: #C3110C;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: color .15s;
    }
    .section-heading a:hover { color: #740A03; }

    /* ── Product cards ────────────────────────────── */
    .home-product-card {
        border: 1px solid #ede4e3;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 10px rgba(40,9,5,.06);
        transition: transform .18s, box-shadow .18s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .home-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(40,9,5,.14);
    }
    .home-product-card .img-wrap {
        position: relative;
        overflow: hidden;
    }
    .home-product-card .img-wrap img,
    .home-product-card .img-wrap .img-placeholder {
        width: 100%; height: 200px; object-fit: cover;
        display: block;
        transition: transform .3s;
    }
    .home-product-card:hover .img-wrap img { transform: scale(1.04); }
    .home-product-card .img-placeholder {
        background: #f5eeec;
        display: flex; align-items: center; justify-content: center;
    }
    .home-product-card .cat-badge {
        position: absolute;
        top: 10px; left: 10px;
        background: rgba(40,9,5,.75);
        color: #f5d5c8;
        font-size: .7rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        letter-spacing: .03em;
        backdrop-filter: blur(4px);
    }
    .home-product-card .card-body {
        padding: 14px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .home-product-card .prod-name {
        font-weight: 700;
        font-size: .92rem;
        color: #1a0503;
        text-decoration: none;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .home-product-card .prod-name:hover { color: #C3110C; }
    .home-product-card .prod-desc {
        font-size: .8rem;
        color: #888;
        margin: 6px 0 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }
    .home-product-card .prod-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: #C3110C;
    }
    .home-product-card .card-footer {
        padding: 10px 16px;
        background: #fdfafa;
        border-top: 1px solid #f0e8e7;
    }
    .btn-add-cart {
        width: 100%;
        background: #C3110C;
        border: none;
        color: #fff;
        padding: 8px;
        border-radius: 6px;
        font-weight: 600;
        font-size: .85rem;
        cursor: pointer;
        transition: background .2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-add-cart:hover { background: #740A03; }
    .btn-add-cart:disabled { background: #aaa; cursor: default; }

    /* ── Category cards ───────────────────────────── */
    .cat-card {
        background: #fff;
        border: 1px solid #ede4e3;
        border-radius: 10px;
        padding: 24px 20px;
        text-align: center;
        text-decoration: none;
        display: block;
        transition: transform .18s, box-shadow .18s, border-color .18s;
        box-shadow: 0 2px 10px rgba(40,9,5,.06);
    }
    .cat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(40,9,5,.14);
        border-color: #C3110C;
        text-decoration: none;
    }
    .cat-icon {
        width: 56px; height: 56px;
        background: linear-gradient(135deg, #280905, #740A03);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px;
        color: #E6501B;
        font-size: 1.4rem;
        transition: transform .18s;
    }
    .cat-card:hover .cat-icon { transform: scale(1.1) rotate(-4deg); }
    .cat-name {
        font-weight: 700;
        font-size: .9rem;
        color: #280905;
        margin-bottom: 3px;
    }
    .cat-count { font-size: .78rem; color: #999; }

    /* ── Sliders ──────────────────────────────────── */
    .slider-wrap {
        position: relative;
        margin-bottom: 48px;
    }
    .slider-viewport {
        overflow-x: clip;
        overflow-y: visible;
    }
    .slider-track {
        display: flex;
        transition: transform .4s cubic-bezier(.4,0,.2,1);
        will-change: transform;
    }
    .slider-track .slide {
        flex: 0 0 25%;
        max-width: 25%;
        padding: 0 8px;
        box-sizing: border-box;
    }
    @media (max-width: 991px) {
        .slider-track .slide { flex: 0 0 50%; max-width: 50%; }
    }
    @media (max-width: 575px) {
        .slider-track .slide { flex: 0 0 100%; max-width: 100%; }
    }
    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px; height: 40px;
        background: #fff;
        border: 2px solid #e0ccc9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        z-index: 10;
        color: #280905;
        font-size: .85rem;
        transition: background .2s, border-color .2s, color .2s, box-shadow .2s;
        box-shadow: 0 2px 8px rgba(40,9,5,.12);
    }
    .slider-btn:hover {
        background: #C3110C;
        border-color: #C3110C;
        color: #fff;
        box-shadow: 0 4px 14px rgba(195,17,12,.35);
    }
    .slider-btn.prev { left: -20px; }
    .slider-btn.next { right: -20px; }
    .slider-btn:disabled { opacity: .35; cursor: default; pointer-events: none; }
    .slider-dots {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 16px;
    }
    .slider-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #d4bab7;
        border: none;
        cursor: pointer;
        transition: background .2s, transform .2s;
        padding: 0;
    }
    .slider-dot.active {
        background: #C3110C;
        transform: scale(1.3);
    }

    /* ── CTA banner ───────────────────────────────── */
    .cta-banner {
        background: linear-gradient(135deg, #280905, #740A03);
        border-radius: 12px;
        padding: 52px 40px;
        text-align: center;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-top: 48px;
    }
    .cta-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 90% at 50% 110%, rgba(230,80,27,.3) 0%, transparent 65%);
        pointer-events: none;
    }
    .cta-banner h2 { font-size: 1.75rem; font-weight: 800; margin-bottom: 10px; }
    .cta-banner p  { color: #f5d5c8; font-size: 1rem; margin-bottom: 24px; max-width: 480px; margin-left: auto; margin-right: auto; }
    .btn-cta {
        background: #E6501B;
        border: none;
        color: #fff;
        padding: 13px 36px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background .2s, transform .2s;
        box-shadow: 0 4px 18px rgba(230,80,27,.4);
    }
    .btn-cta:hover { background: #C3110C; transform: translateY(-2px); color: #fff; }
</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────────── --}}
<div class="hero">
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>

    <div style="position:relative;z-index:1;">
        <div class="hero-badge">
            <i class="fas fa-fire" style="color:#E6501B;"></i> New Arrivals Available
        </div>
        <h1>Your favourite store<br>for <span>quality products</span></h1>
        <p>Browse our carefully curated collection. From everyday essentials to premium picks — find exactly what you need.</p>
        <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('shop.index') }}" class="btn-hero-primary">
                <i class="fas fa-store"></i> Shop Now
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn-hero-outline">
                <i class="fas fa-user-plus"></i> Create Account
            </a>
            @endguest
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="num">{{ $totalProducts }}+</div>
                <div class="lbl">Products</div>
            </div>
            <div class="hero-stat">
                <div class="num">{{ $categories->count() }}</div>
                <div class="lbl">Categories</div>
            </div>
            <div class="hero-stat">
                <div class="num">100%</div>
                <div class="lbl">Secure</div>
            </div>
            <div class="hero-stat">
                <div class="num">24/7</div>
                <div class="lbl">Support</div>
            </div>
        </div>
    </div>
</div>

{{-- ── PERKS STRIP ──────────────────────────────── --}}
<div class="perks-strip">
    <div class="perk-item">
        <div class="perk-icon"><i class="fas fa-truck"></i></div>
        <div>
            <div class="perk-title">Free Shipping</div>
            <div class="perk-sub">On orders over $50</div>
        </div>
    </div>
    <div class="perk-item">
        <div class="perk-icon"><i class="fas fa-shield-alt"></i></div>
        <div>
            <div class="perk-title">Secure Payment</div>
            <div class="perk-sub">100% protected</div>
        </div>
    </div>
    <div class="perk-item">
        <div class="perk-icon"><i class="fas fa-undo-alt"></i></div>
        <div>
            <div class="perk-title">Easy Returns</div>
            <div class="perk-sub">30-day return policy</div>
        </div>
    </div>
    <div class="perk-item">
        <div class="perk-icon"><i class="fas fa-headset"></i></div>
        <div>
            <div class="perk-title">24/7 Support</div>
            <div class="perk-sub">Always here to help</div>
        </div>
    </div>
</div>

{{-- ── FEATURED PRODUCTS ────────────────────────── --}}
@if($featured->isNotEmpty())
<div class="section-heading">
    <h2><i class="fas fa-bolt me-2" style="color:#E6501B;font-size:1rem;"></i>New Arrivals</h2>
    <a href="{{ route('shop.index') }}">View all products <i class="fas fa-arrow-right"></i></a>
</div>

<div class="slider-wrap" id="productsSliderWrap">
    <button class="slider-btn prev" id="productsPrev"><i class="fas fa-chevron-left"></i></button>
    <div class="slider-viewport">
        <div class="slider-track" id="productsTrack">
            @foreach($featured as $product)
            <div class="slide">
                <div class="home-product-card">
                    <div class="img-wrap">
                        <a href="{{ route('shop.show', $product) }}">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="https://picsum.photos/seed/{{ $product->id }}/400/200"
                                     alt="{{ $product->name }}"
                                     style="width:100%;height:200px;object-fit:cover;display:block;">
                            @endif
                        </a>
                        <span class="cat-badge">{{ $product->category->name }}</span>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('shop.show', $product) }}" class="prod-name">{{ $product->name }}</a>
                        <p class="prod-desc">{{ $product->description }}</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="prod-price">${{ number_format($product->price, 2) }}</span>
                            @if($product->stock > 0)
                                <small style="color:#5a9a6a;font-size:.75rem;font-weight:600;">
                                    <i class="fas fa-check-circle me-1"></i>In Stock
                                </small>
                            @else
                                <small style="color:#aaa;font-size:.75rem;">Out of Stock</small>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($product->stock > 0)
                            <button class="btn-add-cart"
                                    data-url="{{ route('cart.add', $product) }}"
                                    data-name="{{ $product->name }}">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        @else
                            <button class="btn-add-cart" disabled>Out of Stock</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <button class="slider-btn next" id="productsNext"><i class="fas fa-chevron-right"></i></button>
    <div class="slider-dots" id="productsDots"></div>
</div>
@endif

{{-- ── CATEGORIES ────────────────────────────────── --}}
@if($categories->isNotEmpty())
<div class="section-heading">
    <h2><i class="fas fa-th-large me-2" style="color:#E6501B;font-size:1rem;"></i>Shop by Category</h2>
</div>

<div class="slider-wrap" id="catsSliderWrap">
    <button class="slider-btn prev" id="catsPrev"><i class="fas fa-chevron-left"></i></button>
    <div class="slider-viewport">
        <div class="slider-track" id="catsTrack">
            @foreach($categories as $cat)
            <div class="slide">
                <a href="{{ route('shop.index', ['categories[]' => $cat->id]) }}" class="cat-card">
                    <div class="cat-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="cat-name">{{ $cat->name }}</div>
                    <div class="cat-count">{{ $cat->products_count }} product{{ $cat->products_count != 1 ? 's' : '' }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <button class="slider-btn next" id="catsNext"><i class="fas fa-chevron-right"></i></button>
    <div class="slider-dots" id="catsDots"></div>
</div>
@endif

{{-- ── CTA BANNER ────────────────────────────────── --}}
@guest
<div class="cta-banner">
    <h2>Ready to start shopping?</h2>
    <p>Create a free account to track your orders, save your favourites, and get exclusive deals.</p>
    <a href="{{ route('register') }}" class="btn-cta">
        <i class="fas fa-user-plus"></i> Get Started — It's Free
    </a>
</div>
@endguest

{{-- Toast --}}
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
// ── Slider factory ────────────────────────────────────
function makeSlider(trackId, prevId, nextId, dotsId) {
    const track   = document.getElementById(trackId);
    const prevBtn = document.getElementById(prevId);
    const nextBtn = document.getElementById(nextId);
    const dotsEl  = document.getElementById(dotsId);

    if (!track) return;

    const slides = track.querySelectorAll('.slide');
    let current  = 0;

    function visibleCount() {
        const w = track.closest('.slider-viewport').offsetWidth;
        if (w < 576) return 1;
        if (w < 992) return 2;
        return 4;
    }

    function totalPages() {
        return Math.ceil(slides.length / visibleCount());
    }

    function buildDots() {
        dotsEl.innerHTML = '';
        for (let i = 0; i < totalPages(); i++) {
            const d = document.createElement('button');
            d.className = 'slider-dot' + (i === current ? ' active' : '');
            d.addEventListener('click', () => goTo(i));
            dotsEl.appendChild(d);
        }
    }

    function goTo(page) {
        const pages = totalPages();
        current = Math.max(0, Math.min(page, pages - 1));
        const pct = current * (visibleCount() / slides.length) * 100;
        track.style.transform = `translateX(-${pct}%)`;
        prevBtn.disabled = current === 0;
        nextBtn.disabled = current === pages - 1;
        dotsEl.querySelectorAll('.slider-dot').forEach((d, i) => d.classList.toggle('active', i === current));
    }

    prevBtn.addEventListener('click', () => goTo(current - 1));
    nextBtn.addEventListener('click', () => goTo(current + 1));

    // Initialise track item widths via CSS (handled by .slide flex rules)
    buildDots();
    goTo(0);

    // Rebuild on resize
    window.addEventListener('resize', () => { buildDots(); goTo(0); });
}

makeSlider('productsTrack', 'productsPrev', 'productsNext', 'productsDots');
makeSlider('catsTrack',     'catsPrev',     'catsNext',     'catsDots');

// ── Add to cart ───────────────────────────────────────
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
        btn.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart');
    });
});
</script>
@endpush
