<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link" target="_blank">
                <i class="fas fa-store mr-1"></i> View Shop
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center gap-2" data-toggle="dropdown" href="#" style="gap:8px;">
                <div style="width:30px;height:30px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:#fff;flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span style="font-size:.875rem;color:#2d3748;font-weight:500;">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down" style="font-size:.65rem;color:#94a3b8;"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="border:none;box-shadow:0 8px 24px rgba(0,0,0,.12);border-radius:10px;min-width:180px;padding:6px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item" style="border-radius:6px;font-size:.85rem;color:#ef4444;padding:9px 14px;">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
