@php $cartCount = array_sum(session()->get('cart', [])); @endphp

<nav class="navbar navbar-expand-lg navbar-dark navbar-shop">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="fas fa-shopping-bag me-2"></i>Laravel Shop
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        <i class="fas fa-home me-1" style="font-size:.8rem;opacity:.8;"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop.index', 'shop.show') ? 'active' : '' }}"
                       href="{{ route('shop.index') }}">
                        <i class="fas fa-store me-1" style="font-size:.8rem;opacity:.8;"></i>Shop
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                       href="{{ route('contact') }}">
                        <i class="fas fa-envelope me-1" style="font-size:.8rem;opacity:.8;"></i>Contact
                    </a>
                </li>
            </ul>

            {{-- Search --}}
            <form class="d-flex ms-auto me-3 navbar-search" style="max-width:260px;position:relative;" method="GET" action="{{ route('shop.index') }}">
                <div class="input-group input-group-sm" style="position:relative;">
                    <input type="text" id="navSearchInput" name="search" class="form-control" placeholder="Search products..."
                           value="{{ request('search') }}" autocomplete="off">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </div>
                <div id="searchDropdown" style="
                    display:none;
                    position:absolute;
                    top:calc(100% + 6px);
                    left:0; right:0;
                    background:#fff;
                    border-radius:0 0 10px 10px;
                    border:1px solid #e0ccc9;
                    border-top:3px solid #C3110C;
                    box-shadow:0 8px 24px rgba(40,9,5,.18);
                    z-index:9999;
                    overflow:hidden;
                    min-width:300px;
                "></div>
            </form>

            <ul class="navbar-nav align-items-center gap-1">
                {{-- Cart --}}
                <li class="nav-item">
                    <a class="nav-link no-underline" href="{{ route('cart.index') }}"
                       style="position:relative; display:inline-flex; align-items:center; padding-right:18px;">
                        <i class="fas fa-shopping-cart" style="font-size:1.1rem;"></i>
                        <span id="cartCount"
                              style="position:absolute; top:-2px; right:2px; background:#E6501B; color:#fff;
                                     font-size:.65rem; font-weight:700; min-width:17px; height:17px;
                                     border-radius:9px; display:{{ $cartCount == 0 ? 'none' : 'flex' }};
                                     align-items:center; justify-content:center; padding:0 4px;
                                     line-height:1; border:2px solid #280905;">
                            {{ $cartCount }}
                        </span>
                    </a>
                </li>

                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle no-underline" href="#" data-bs-toggle="dropdown">
                        <span class="user-toggle">
                            <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <span>{{ auth()->user()->name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-box me-2"></i>My Orders</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        @if(auth()->user()->isAdmin())
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2"></i>Admin Panel</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link btn-nav-login" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-nav-register" href="{{ route('register') }}">Register</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
