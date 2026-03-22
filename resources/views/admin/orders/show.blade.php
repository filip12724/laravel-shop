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
                        @php
                            $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                            $shipping = round($order->total - $subtotal, 2);
                        @endphp
                        <tr style="background:#f7f9fe;">
                            <td colspan="3" class="text-right" style="font-weight:600;color:#64748b;font-size:.88rem;">Subtotal</td>
                            <td style="font-weight:600;">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr style="background:#f7f9fe;">
                            <td colspan="3" class="text-right" style="font-weight:600;color:#64748b;font-size:.88rem;">Shipping</td>
                            <td>
                                @if($shipping <= 0)
                                    <span style="color:#4f46e5;font-weight:600;"><i class="fas fa-check-circle mr-1" style="font-size:.8rem;"></i>Free</span>
                                @else
                                    <span style="font-weight:600;">${{ number_format($shipping, 2) }}</span>
                                @endif
                            </td>
                        </tr>
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
                <div style="font-weight:700;font-size:.95rem;margin-bottom:2px;">{{ $order->user?->name ?? 'Guest' }}</div>
                <div style="color:#94a3b8;font-size:.82rem;margin-bottom:14px;">{{ $order->user?->email ?? $order->guest_email ?? '—' }}</div>
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
                @php
                    $transitions = \App\Http\Controllers\Admin\OrderController::allowedTransitions();
                    $allowed = $transitions[$order->status] ?? [];
                @endphp
                @if(empty($allowed))
                    <p style="font-size:.82rem;color:#94a3b8;margin:0;">
                        <i class="fas fa-lock mr-1"></i> This order is <strong>{{ $order->status }}</strong> and cannot be changed.
                    </p>
                @else
                    <div style="display:flex;flex-wrap:wrap;gap:6px;" id="statusBtns">
                        @foreach($allowed as $s)
                            <button class="btn btn-sm btn-status {{ $s === 'cancelled' ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                                    data-status="{{ $s }}" data-url="{{ route('admin.orders.status', $order) }}"
                                    {{ $s === 'cancelled' ? 'id="btnCancel"' : '' }}>
                                {{ ucfirst($s) }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Cancel reason modal --}}
<div id="cancelModal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;">
    <div style="position:absolute;inset:0;background:rgba(0,0,0,.5);backdrop-filter:blur(3px);" id="cancelModalBackdrop"></div>
    <div style="position:relative;background:#fff;border-radius:16px;padding:28px;width:100%;max-width:440px;margin:auto;animation:modalIn .2s ease;box-shadow:0 20px 60px rgba(0,0,0,.3);">
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-times-circle" style="color:#ef4444;font-size:1.2rem;"></i>
            </div>
            <div>
                <div style="font-weight:700;font-size:1rem;color:#1a202c;">Cancel Order #{{ $order->id }}</div>
                <div style="font-size:.82rem;color:#94a3b8;">This cannot be undone.</div>
            </div>
        </div>
        <div style="margin-bottom:18px;">
            <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;display:block;margin-bottom:6px;">
                <i class="fas fa-comment-alt mr-1" style="color:#4f46e5;"></i> Reason for cancellation
                <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#94a3b8;font-size:.75rem;margin-left:4px;">optional</span>
            </label>
            <textarea id="cancelReason" rows="3" placeholder="e.g. Item out of stock, payment issue..."
                style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.875rem;resize:vertical;outline:none;transition:border-color .2s;"
                onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,.12)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"></textarea>
        </div>
        <div style="display:flex;gap:10px;">
            <button id="cancelModalClose" class="btn btn-outline-secondary" style="flex:1;">Cancel</button>
            <button id="cancelModalConfirm" class="btn btn-danger" style="flex:1;">
                <i class="fas fa-times mr-1"></i> Confirm Cancellation
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let cancelUrl = null;

$(document).on('click', '.btn-status', function () {
    const btn = $(this), status = btn.data('status'), url = btn.data('url');

    if (status === 'cancelled') {
        cancelUrl = url;
        $('#cancelReason').val('');
        $('#cancelModal').css('display', 'flex');
        return;
    }

    btn.prop('disabled', true);
    $.ajax({ url, type: 'PATCH', data: { _token: '{{ csrf_token() }}', status },
        success: res => { if (res.success) location.reload(); },
        error: () => btn.prop('disabled', false)
    });
});

$('#cancelModalConfirm').on('click', function () {
    const btn = $(this);
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm mr-1"></span> Cancelling...');
    $.ajax({
        url: cancelUrl, type: 'PATCH',
        data: { _token: '{{ csrf_token() }}', status: 'cancelled', cancel_reason: $('#cancelReason').val().trim() },
        success: res => { if (res.success) location.reload(); },
        error: () => { btn.prop('disabled', false).html('<i class="fas fa-times mr-1"></i> Confirm Cancellation'); }
    });
});

$('#cancelModalClose, #cancelModalBackdrop').on('click', function () {
    $('#cancelModal').hide();
});
</script>
@endpush
