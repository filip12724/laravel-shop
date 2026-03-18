@extends('layouts.app')
@section('title', 'My Orders')

@push('styles')
<style>
    .orders-header {
        background: linear-gradient(135deg, #280905, #740A03);
        color: #fff;
        border-radius: 8px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .orders-header i { color: #E6501B; font-size: 1.6rem; }
    .orders-header h2 { margin: 0; font-size: 1.5rem; }

    .orders-table-wrap {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 14px rgba(40,9,5,.1);
    }
    .orders-table-wrap table thead tr {
        background: #280905;
        color: #fff;
    }
    .orders-table-wrap table thead th {
        font-weight: 600;
        font-size: .85rem;
        letter-spacing: .04em;
        text-transform: uppercase;
        padding: 13px 16px;
        border: none;
    }
    .orders-table-wrap table tbody tr {
        border-bottom: 1px solid #f0e8e7;
        transition: background .15s;
    }
    .orders-table-wrap table tbody tr:hover { background: #fdf5f4; }
    .orders-table-wrap table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border: none;
        font-size: .9rem;
    }
    .order-id { font-weight: 700; color: #740A03; }

    /* Status badges */
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .02em;
    }
    .status-pending    { background: #fff3cd; color: #856404; }
    .status-processing { background: #cfe2ff; color: #084298; }
    .status-shipped    { background: #d1ecf1; color: #0c5460; }
    .status-delivered  { background: #d1e7dd; color: #0a3622; }
    .status-cancelled  { background: #f8d7da; color: #58151c; }

    .btn-view-order {
        padding: 5px 14px;
        font-size: .8rem;
        font-weight: 600;
        border: 1.5px solid #C3110C;
        border-radius: 4px;
        color: #C3110C;
        background: transparent;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-view-order:hover { background: #C3110C; color: #fff; }

    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { color: #c9a09a; }
    .empty-state h4 { color: #740A03; margin: 16px 0 8px; }
    .empty-state p { color: #888; font-size: .9rem; }
</style>
@endpush

@section('content')

<div class="orders-header">
    <i class="fas fa-box-open"></i>
    <h2>My Orders</h2>
</div>

@if($orders->isEmpty())
    <div class="empty-state">
        <i class="fas fa-shopping-bag fa-4x"></i>
        <h4>No orders yet</h4>
        <p>You haven't placed any orders. Start shopping to see them here.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-primary mt-2">
            <i class="fas fa-store me-2"></i>Browse Products
        </a>
    </div>
@else
    <div class="orders-table-wrap">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><span class="order-id">#{{ $order->id }}</span></td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>{{ $order->items->count() }} item(s)</td>
                    <td style="font-weight:600; color:#280905;">${{ number_format($order->total, 2) }}</td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order) }}" class="btn-view-order">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $orders->links() }}</div>
@endif

@endsection
