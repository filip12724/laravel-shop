<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text">
            <i class="fas fa-shopping-bag mr-2"></i>Laravel Shop
        </span>
    </a>

    <div class="sidebar">
        <div class="user-panel d-flex align-items-center">
            <div class="user-avatar-circle">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                <small>Administrator</small>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">Catalog</li>

                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Categories</p>
                    </a>
                </li>

                <li class="nav-header">Sales</li>

                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Orders</p>
                    </a>
                </li>

                <li class="nav-header">Users & Reports</li>

                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logs.index') }}" class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Activity Logs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Messages</p>
                        @php $unread = \App\Models\ContactMessage::where('read', false)->count(); @endphp
                        @if($unread > 0)
                            <span class="badge badge-danger right">{{ $unread }}</span>
                        @endif
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
