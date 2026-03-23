<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --color-main:      #280905;
            --color-secondary: #740A03;
            --color-third:     #C3110C;
            --color-fourth:    #E6501B;
        }

        /* Navbar */
        .navbar-shop {
            background: linear-gradient(90deg, #280905 0%, #3d0c07 100%);
            border-bottom: 3px solid #C3110C;
            box-shadow: 0 2px 12px rgba(0,0,0,.35);
            padding-top: .65rem;
            padding-bottom: .65rem;
        }
        .navbar-shop .navbar-brand {
            color: #fff !important;
            font-size: 1.25rem;
            letter-spacing: .5px;
        }
        .navbar-shop .navbar-brand i { color: #E6501B; }
        .navbar-shop .navbar-brand:hover i { color: #ff7a40; }

        .navbar-shop .nav-link {
            color: #f5d5c8 !important;
            font-size: .9rem;
            font-weight: 500;
            padding: .45rem .75rem !important;
            position: relative;
            transition: color .2s;
        }
        .navbar-shop .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%; right: 50%;
            height: 2px;
            background: #E6501B;
            border-radius: 2px;
            transition: left .2s, right .2s;
        }
        .navbar-shop .nav-link:hover,
        .navbar-shop .nav-link.active { color: #fff !important; }
        .navbar-shop .nav-link:hover::after,
        .navbar-shop .nav-link.active::after { left: 8px; right: 8px; }
        /* don't apply underline to cart/dropdown/btn links */
        .navbar-shop .nav-link.no-underline::after,
        .navbar-shop .nav-item.dropdown .nav-link::after,
        .navbar-shop .btn-nav-login::after,
        .navbar-shop .btn-nav-register::after { display: none; }

        /* Search */
        .navbar-shop .navbar-search .form-control {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            color: #fff;
            border-radius: 20px 0 0 20px;
            font-size: .85rem;
        }
        .navbar-shop .navbar-search .form-control::placeholder { color: rgba(255,255,255,.5); }
        .navbar-shop .navbar-search .form-control:focus {
            background: rgba(255,255,255,.18);
            border-color: #E6501B;
            box-shadow: none;
            color: #fff;
        }
        .navbar-shop .navbar-search .btn {
            background: #C3110C;
            border: 1px solid #C3110C;
            color: #fff;
            border-radius: 0 20px 20px 0;
            padding: .25rem .75rem;
        }
        .navbar-shop .navbar-search .btn:hover { background: #E6501B; border-color: #E6501B; }

        /* Login / Register pills */
        .navbar-shop .btn-nav-login {
            color: #f5d5c8;
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 20px;
            padding: .3rem .9rem;
            font-size: .85rem;
            transition: background .2s, border-color .2s, color .2s;
        }
        .navbar-shop .btn-nav-login:hover { background: rgba(255,255,255,.12); color: #fff; border-color: #fff; }
        .navbar-shop .btn-nav-register {
            background: #C3110C;
            border: 1px solid #C3110C;
            color: #fff;
            border-radius: 20px;
            padding: .3rem .9rem;
            font-size: .85rem;
            transition: background .2s;
        }
        .navbar-shop .btn-nav-register:hover { background: #E6501B; border-color: #E6501B; }

        /* User dropdown toggle */
        .navbar-shop .user-toggle {
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .navbar-shop .user-toggle .user-avatar {
            width: 30px; height: 30px;
            background: #C3110C;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }

        /* Dropdown */
        .navbar-shop .dropdown-menu {
            border: none;
            border-top: 3px solid #C3110C;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 8px 24px rgba(40,9,5,.35);
            background: #280905;
            min-width: 200px;
            padding: 6px 0;
        }
        .navbar-shop .dropdown-item {
            color: #f5d5c8;
            font-size: .88rem;
            padding: 9px 18px;
            transition: background .15s, color .15s;
        }
        .navbar-shop .dropdown-item:hover,
        .navbar-shop .dropdown-item:focus,
        .navbar-shop .dropdown-item:active { background: #740A03; color: #fff; }
        .navbar-shop .dropdown-item i { color: #E6501B; width: 16px; }
        .navbar-shop .dropdown-item:hover i,
        .navbar-shop .dropdown-item:focus i { color: #ffb89a; }
        .navbar-shop .dropdown-divider { border-color: #4a1208; margin: 4px 0; }
        .navbar-shop .dropdown-item.text-danger { color: #ff9b8a !important; }
        .navbar-shop .dropdown-item.text-danger:hover { background: #C3110C; color: #fff !important; }

        /* Footer handled inline */

        /* Buttons — override Bootstrap primary via CSS variables (covers ALL states incl. disabled/spinner) */
        .btn-primary {
            --bs-btn-bg:                  #C3110C;
            --bs-btn-border-color:        #C3110C;
            --bs-btn-hover-bg:            #740A03;
            --bs-btn-hover-border-color:  #740A03;
            --bs-btn-active-bg:           #740A03;
            --bs-btn-active-border-color: #740A03;
            --bs-btn-disabled-bg:         #C3110C;
            --bs-btn-disabled-border-color: #C3110C;
            --bs-btn-focus-shadow-rgb:    195, 17, 12;
            color: #fff;
        }
        .btn-outline-primary {
            color: var(--color-third);
            border-color: var(--color-third);
        }
        .btn-outline-primary:hover {
            background-color: var(--color-third);
            border-color: var(--color-third);
            color: #fff;
        }

        /* Text & links */
        .text-primary { color: var(--color-third) !important; }
        a.text-decoration-none:hover { color: var(--color-third) !important; }

        /* Badges */
        .badge.bg-primary { background-color: var(--color-third) !important; }
        .badge.bg-danger  { background-color: var(--color-fourth) !important; }

        /* Pagination */
        .page-link { color: var(--color-third); }
        .page-link:hover { color: var(--color-secondary); }
        .page-item.active .page-link {
            background-color: var(--color-third);
            border-color: var(--color-third);
        }

        /* Product card hover */
        .product-card { transition: transform .15s, box-shadow .15s; }
        .product-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(40,9,5,.15) !important; }

        /* Section heading accent */
        .section-title { border-left: 4px solid var(--color-third); padding-left: .75rem; }

        /* Remove number input spinners sitewide */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; text-align: center; }

        /* Kill blue focus rings everywhere — replace with palette colour */
        *:focus { outline: none !important; box-shadow: 0 0 0 .2rem rgba(195,17,12,.25) !important; }
        .btn:focus-visible { box-shadow: 0 0 0 .2rem rgba(195,17,12,.35) !important; }
        .form-control:focus, .form-select:focus { border-color: #C3110C !important; box-shadow: 0 0 0 .2rem rgba(195,17,12,.2) !important; }

        /* Sticky footer */
        html, body { height: 100%; }
        body { display: flex; flex-direction: column; }
        body > main { flex: 1; }
</style>

    @stack('styles')
</head>
<body class="bg-light">

    @include('partials.navbar')

    <main class="container my-4">
        @unless($hideGlobalAlert ?? false)
            @include('partials.alerts')
        @endunless
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Global success toast --}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
        <div id="globalSuccessToast" class="toast align-items-center text-white border-0" role="alert"
             style="background:#C3110C; min-width:260px;">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span id="globalSuccessMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('globalSuccessMessage').textContent = @json(session('success'));
            new bootstrap.Toast(document.getElementById('globalSuccessToast'), { delay: 5000 }).show();
        });
    </script>
    @endif

    <script>
    (function () {
        const input    = document.getElementById('navSearchInput');
        const dropdown = document.getElementById('searchDropdown');
        if (!input || !dropdown) return;

        const SEARCH_URL = '{{ route('search') }}';
        const PICSUM     = 'https://picsum.photos/seed/';
        let timer;

        function placeholderImg(id) {
            return PICSUM + id + '/80/80';
        }

        function render(results) {
            if (!results.length) {
                dropdown.innerHTML = '<div style="padding:14px 16px;color:#888;font-size:.875rem;">No products found.</div>';
            } else {
                dropdown.innerHTML = results.map(p => `
                    <a href="${p.url}" style="
                        display:flex;align-items:center;gap:12px;
                        padding:10px 14px;text-decoration:none;color:inherit;
                        border-bottom:1px solid #f5eeec;transition:background .15s;
                    " onmouseover="this.style.background='#fdf5f4'" onmouseout="this.style.background=''">
                        <img src="${p.image || placeholderImg(p.id)}"
                             width="46" height="46"
                             style="object-fit:cover;border-radius:6px;flex-shrink:0;border:1px solid #f0e8e7;">
                        <div style="min-width:0;">
                            <div style="font-weight:600;font-size:.875rem;color:#1a0503;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${p.name}</div>
                            <div style="font-size:.75rem;color:#999;margin-top:1px;">${p.category}</div>
                        </div>
                        <div style="margin-left:auto;flex-shrink:0;font-weight:700;color:#C3110C;font-size:.9rem;">$${p.price}</div>
                    </a>
                `).join('') + `
                    <a href="{{ route('shop.index') }}?search=${encodeURIComponent(input.value)}" style="
                        display:block;padding:10px 14px;text-align:center;
                        font-size:.8rem;font-weight:600;color:#C3110C;
                        text-decoration:none;background:#fdfafa;
                    " onmouseover="this.style.background='#f5eeec'" onmouseout="this.style.background='#fdfafa'">
                        View all results <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                `;
            }
            dropdown.style.display = 'block';
        }

        function hide() {
            dropdown.style.display = 'none';
        }

        input.addEventListener('input', function () {
            clearTimeout(timer);
            const q = this.value.trim();
            if (q.length < 2) { hide(); return; }
            dropdown.innerHTML = '<div style="padding:14px 16px;color:#aaa;font-size:.875rem;"><span class="spinner-border spinner-border-sm me-2"></span>Searching…</div>';
            dropdown.style.display = 'block';
            timer = setTimeout(() => {
                fetch(SEARCH_URL + '?q=' + encodeURIComponent(q))
                    .then(r => r.json())
                    .then(render);
            }, 250);
        });

        // Hide when clicking outside
        document.addEventListener('click', function (e) {
            if (!input.closest('form').contains(e.target)) hide();
        });

        // Keep open when clicking inside dropdown
        dropdown.addEventListener('mousedown', e => e.preventDefault());
    })();
    </script>

    @stack('scripts')
</body>
</html>
