@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Orders</h3>
    </div>
    <div class="card-body">
        <form class="mb-3 d-flex flex-wrap gap-2" method="GET">
            <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search customer..." value="{{ request('search') }}">
            <select name="status" class="form-control form-control-sm w-auto">
                <option value="">All statuses</option>
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-secondary" type="submit">Filter</button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>

        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}<br><small class="text-muted">{{ $order->user->email }}</small></td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>@include('admin.partials.order-status', ['status' => $order->status])</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-xs btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $orders->links() }}
    </div>
</div>
@endsection
