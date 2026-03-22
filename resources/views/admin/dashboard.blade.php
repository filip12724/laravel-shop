@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- Stat cards --}}
<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon blue"><i class="fas fa-users"></i></div>
            <div>
                <div class="admin-stat-num">{{ $stats['users'] }}</div>
                <div class="admin-stat-lbl">Total Users</div>
                <a href="{{ route('admin.users.index') }}" class="admin-stat-link">Manage <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon indigo"><i class="fas fa-box"></i></div>
            <div>
                <div class="admin-stat-num">{{ $stats['products'] }}</div>
                <div class="admin-stat-lbl">Products</div>
                <a href="{{ route('admin.products.index') }}" class="admin-stat-link">Manage <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon amber"><i class="fas fa-shopping-cart"></i></div>
            <div>
                <div class="admin-stat-num">{{ $stats['orders'] }}</div>
                <div class="admin-stat-lbl">Orders</div>
                <a href="{{ route('admin.orders.index') }}" class="admin-stat-link">View all <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon green"><i class="fas fa-dollar-sign"></i></div>
            <div>
                <div class="admin-stat-num">${{ number_format($stats['revenue'], 0) }}</div>
                <div class="admin-stat-lbl">Revenue</div>
                <a href="{{ route('admin.orders.index') }}" class="admin-stat-link">View orders <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

{{-- Recent orders + activity --}}
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title"><i class="fas fa-shopping-cart mr-2" style="color:#4f46e5;"></i>Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">View all</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}" style="color:#4f46e5;font-weight:600;">#{{ $order->id }}</a></td>
                            <td>{{ $order->user?->name ?? $order->guest_email ?? 'Guest' }}</td>
                            <td style="font-weight:600;">${{ number_format($order->total, 2) }}</td>
                            <td>@include('admin.partials.order-status', ['status' => $order->status])</td>
                            <td style="color:#94a3b8;">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center" style="color:#94a3b8;padding:24px;">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title"><i class="fas fa-history mr-2" style="color:#4f46e5;"></i>Recent Activity</h3>
                <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-outline-secondary">View all</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentLogs as $log)
                <div style="padding:12px 20px;border-bottom:1px solid #f0f3f9;display:flex;gap:12px;align-items:flex-start;">
                    <div style="width:8px;height:8px;background:#4f46e5;border-radius:50%;margin-top:6px;flex-shrink:0;"></div>
                    <div>
                        <div style="font-size:.82rem;color:#2d3748;">{{ $log->description }}</div>
                        <div style="font-size:.75rem;color:#94a3b8;margin-top:2px;">
                            <span class="badge badge-secondary" style="font-size:.68rem;">{{ $log->action }}</span>
                            &nbsp;{{ $log->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @empty
                <div style="padding:24px;text-align:center;color:#94a3b8;font-size:.875rem;">No activity yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
