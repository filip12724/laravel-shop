@extends('layouts.admin')
@section('title', 'Order #' . $order->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title">
                    <i class="fas fa-receipt mr-2" style="color:#4f46e5;"></i>Order #{{ $order->id }} — Items
                </h3>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td style="font-weight:500;">{{ $item->product->name }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="font-weight:600;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr style="background:#f7f9fe;">
                            <td colspan="3" class="text-right" style="font-weight:700;color:#1a202c;">Total</td>
                            <td style="font-weight:800;font-size:1rem;color:#4f46e5;">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user mr-2" style="color:#4f46e5;"></i>Customer</h3>
            </div>
            <div class="card-body">
                <div style="font-weight:700;font-size:.95rem;margin-bottom:2px;">{{ $order->user->name }}</div>
                <div style="color:#94a3b8;font-size:.82rem;margin-bottom:14px;">{{ $order->user->email }}</div>
                <div style="border-top:1px solid #f0f3f9;padding-top:12px;">
                    <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:8px;">Shipping Address</div>
                    <div style="font-size:.875rem;color:#2d3748;line-height:1.6;">
                        {{ $order->shipping_name }}<br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_zip }}
                    </div>
                </div>
                @if($order->notes)
                    <div style="margin-top:12px;background:#fffbeb;border-radius:8px;padding:10px 12px;font-size:.82rem;color:#92400e;">
                        <i class="fas fa-sticky-note mr-1"></i> {{ $order->notes }}
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tag mr-2" style="color:#4f46e5;"></i>Order Status</h3>
            </div>
            <div class="card-body">
                <div style="margin-bottom:14px;">
                    Current: @include('admin.partials.order-status', ['status' => $order->status])
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:6px;" id="statusBtns">
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                        <button class="btn btn-sm btn-status {{ $order->status === $s ? 'btn-primary' : 'btn-outline-secondary' }}"
                                data-status="{{ $s }}" data-url="{{ route('admin.orders.status', $order) }}">
                            {{ ucfirst($s) }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.btn-status', function () {
    const btn = $(this), status = btn.data('status'), url = btn.data('url');
    $.ajax({ url, type: 'PATCH', data: { _token: '{{ csrf_token() }}', status },
        success: res => {
            if (res.success) {
                $('#statusBtns .btn-status').removeClass('btn-primary').addClass('btn-outline-secondary');
                btn.removeClass('btn-outline-secondary').addClass('btn-primary');
            }
        }
    });
});
</script>
@endpush
