@extends('layouts.app')
@section('title', 'Order #' . $order->id)

@push('styles')
<style>
    .order-hero {
        background: linear-gradient(135deg, #280905, #740A03);
        color: #fff;
        border-radius: 8px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .order-hero-left { display: flex; align-items: center; gap: 12px; }
    .order-hero-left i { color: #E6501B; font-size: 1.5rem; }
    .order-hero h2 { margin: 0; font-size: 1.4rem; }
    .order-hero small { color: #c9a09a; font-size: .82rem; }

    .btn-back {
        padding: 7px 16px;
        font-size: .85rem;
        font-weight: 600;
        border: 1.5px solid rgba(255,255,255,.5);
        border-radius: 4px;
        color: #fff;
        background: transparent;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-back:hover { background: rgba(255,255,255,.15); color: #fff; }

    /* Info cards */
    .info-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(40,9,5,.09);
        overflow: hidden;
        height: 100%;
    }
    .info-card .info-card-header {
        background: #280905;
        color: #fff;
        padding: 11px 18px;
        font-weight: 700;
        font-size: .85rem;
        letter-spacing: .04em;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .info-card .info-card-header i { color: #E6501B; }
    .info-card .info-card-body { padding: 18px; }
    .info-card .info-row { display: flex; gap: 8px; margin-bottom: 8px; font-size: .9rem; }
    .info-row .label { color: #740A03; font-weight: 600; min-width: 70px; }
    .info-row .value { color: #333; }

    /* Status badge */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: .8rem;
        font-weight: 600;
    }
    .status-pending    { background: #fff3cd; color: #856404; }
    .status-processing { background: #cfe2ff; color: #084298; }
    .status-shipped    { background: #d1ecf1; color: #0c5460; }
    .status-delivered  { background: #d1e7dd; color: #0a3622; }
    .status-cancelled  { background: #f8d7da; color: #58151c; }

    /* Items table */
    .items-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(40,9,5,.09);
        overflow: hidden;
    }
    .items-card .items-header {
        background: #280905;
        color: #fff;
        padding: 11px 18px;
        font-weight: 700;
        font-size: .85rem;
        letter-spacing: .04em;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .items-card .items-header i { color: #E6501B; }
    .items-card table thead tr { background: #f5eeec; }
    .items-card table thead th {
        padding: 10px 16px;
        font-size: .82rem;
        font-weight: 700;
        color: #740A03;
        text-transform: uppercase;
        letter-spacing: .04em;
        border: none;
    }
    .items-card table tbody tr { border-bottom: 1px solid #f0e8e7; }
    .items-card table tbody tr:last-child { border-bottom: none; }
    .items-card table tbody td { padding: 13px 16px; border: none; font-size: .9rem; vertical-align: middle; }
    .items-card table tfoot tr { background: #fdf5f4; }
    .items-card table tfoot th {
        padding: 13px 16px;
        border: none;
        font-size: .95rem;
        color: #280905;
    }
    .total-amount { color: #C3110C; font-size: 1.1rem; }

    .product-link { color: #740A03; text-decoration: none; font-weight: 500; }
    .product-link:hover { color: #C3110C; text-decoration: underline; }
</style>
@endpush

@section('content')

<div class="order-hero">
    <div class="order-hero-left">
        <i class="fas fa-receipt"></i>
        <div>
            <h2>Order #{{ $order->id }}</h2>
            <small>Placed on {{ $order->created_at->format('F d, Y \a\t H:i') }}</small>
        </div>
    </div>
    <a href="{{ route('orders.index') }}" class="btn-back">
        <i class="fas fa-arrow-left me-1"></i> My Orders
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-info-circle"></i> Order Details
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="label">Status</span>
                    <span class="value">
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Date</span>
                    <span class="value">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Total</span>
                    <span class="value" style="font-weight:700; color:#C3110C; font-size:1.05rem;">
                        ${{ number_format($order->total, 2) }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Items</span>
                    <span class="value">{{ $order->items->count() }} item(s)</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-map-marker-alt"></i> Shipping Address
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="label">Name</span>
                    <span class="value">{{ $order->shipping_name }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Address</span>
                    <span class="value">{{ $order->shipping_address }}</span>
                </div>
                <div class="info-row">
                    <span class="label">City</span>
                    <span class="value">{{ $order->shipping_city }}, {{ $order->shipping_zip }}</span>
                </div>
                @if($order->notes)
                <div class="info-row" style="margin-top:10px; padding-top:10px; border-top:1px solid #f0e8e7;">
                    <span class="label">Notes</span>
                    <span class="value text-muted"><em>{{ $order->notes }}</em></span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="items-card">
    <div class="items-header">
        <i class="fas fa-box"></i> Order Items
    </div>
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <a href="{{ route('shop.show', $item->product) }}" class="product-link">
                        {{ $item->product->name }}
                    </a>
                </td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>× {{ $item->quantity }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Order Total</th>
                <th class="total-amount">${{ number_format($order->total, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>

@endsection
