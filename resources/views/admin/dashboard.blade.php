@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['users'] }}</h3>
                <p>Users</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['products'] }}</h3>
                <p>Products</p>
            </div>
            <div class="icon"><i class="fas fa-box"></i></div>
            <a href="{{ route('admin.products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['orders'] }}</h3>
                <p>Orders</p>
            </div>
            <div class="icon"><i class="fas fa-shopping-cart"></i></div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>${{ number_format($stats['revenue'], 2) }}</h3>
                <p>Revenue</p>
            </div>
            <div class="icon"><i class="fas fa-dollar-sign"></i></div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-shopping-cart mr-2"></i>Recent Orders</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
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
                            <td><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a></td>
                            <td>{{ $order->user->name }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>@include('admin.partials.order-status', ['status' => $order->status])</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history mr-2"></i>Recent Activity</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentLogs as $log)
                    <li class="list-group-item py-2 px-3">
                        <small class="text-muted d-block">{{ $log->created_at->diffForHumans() }}</small>
                        <span class="badge badge-secondary">{{ $log->action }}</span>
                        {{ $log->description }}
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center">No activity yet.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.logs.index') }}">View all logs</a>
            </div>
        </div>
    </div>
</div>
@endsection
