<footer style="background: #280905; color: #f5d5c8; margin-top: 3rem;">
    <div style="background: #740A03; height: 4px;"></div>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h6 class="fw-bold mb-2" style="color: #fff;">
                    <i class="fas fa-shopping-bag me-2" style="color: #E6501B;"></i>Laravel Shop
                </h6>
                <p style="color: #c9a09a; font-size: .875rem; margin-bottom: 0;">
                    Your one-stop shop for quality products at great prices.
                </p>
            </div>

            <div class="col-md-4 mb-3">
                <h6 class="fw-bold mb-2" style="color: #fff; border-left: 3px solid #C3110C; padding-left: 8px;">
                    Quick Links
                </h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-1">
                        <a href="{{ route('shop.index') }}"
                           style="color: #c9a09a; text-decoration: none; font-size: .875rem;"
                           onmouseover="this.style.color='#E6501B'" onmouseout="this.style.color='#c9a09a'">
                            <i class="fas fa-store me-1" style="font-size:.75rem;"></i> Shop
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}"
                           style="color: #c9a09a; text-decoration: none; font-size: .875rem;"
                           onmouseover="this.style.color='#E6501B'" onmouseout="this.style.color='#c9a09a'">
                            <i class="fas fa-envelope me-1" style="font-size:.75rem;"></i> Contact
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 mb-3">
                <h6 class="fw-bold mb-2" style="color: #fff; border-left: 3px solid #C3110C; padding-left: 8px;">
                    My Account
                </h6>
                <ul class="list-unstyled mb-0">
                    @auth
                    <li class="mb-1">
                        <a href="{{ route('orders.index') }}"
                           style="color: #c9a09a; text-decoration: none; font-size: .875rem;"
                           onmouseover="this.style.color='#E6501B'" onmouseout="this.style.color='#c9a09a'">
                            <i class="fas fa-box me-1" style="font-size:.75rem;"></i> My Orders
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}"
                           style="color: #c9a09a; text-decoration: none; font-size: .875rem;"
                           onmouseover="this.style.color='#E6501B'" onmouseout="this.style.color='#c9a09a'">
                            <i class="fas fa-shopping-cart me-1" style="font-size:.75rem;"></i> Cart
                        </a>
                    </li>
                    @else
                    <li class="mb-1">
                        <a href="{{ route('login') }}"
                           style="color: #c9a09a; text-decoration: none; font-size: .875rem;"
                           onmouseover="this.style.color='#E6501B'" onmouseout="this.style.color='#c9a09a'">
                            <i class="fas fa-sign-in-alt me-1" style="font-size:.75rem;"></i> Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}"
                           style="color: #c9a09a; text-decoration: none; font-size: .875rem;"
                           onmouseover="this.style.color='#E6501B'" onmouseout="this.style.color='#c9a09a'">
                            <i class="fas fa-user-plus me-1" style="font-size:.75rem;"></i> Register
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>

        <div style="border-top: 1px solid #4a1208; margin-top: .5rem; padding-top: 1rem; text-align: center;">
            <p style="color: #8a4040; font-size: .8rem; margin: 0;">
                &copy; {{ date('Y') }} Laravel Shop &mdash; All rights reserved.
            </p>
        </div>
    </div>
</footer>
