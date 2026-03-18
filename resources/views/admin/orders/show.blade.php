@extends('layouts.admin')
@section('title', 'Order #' . $order->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order #{{ $order->id }} Items</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
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
                            <td>{{ $item->product->name }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="font-weight-bold">
                            <td colspan="3" class="text-right">Total:</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Customer</h3></div>
            <div class="card-body">
                <p><strong>{{ $order->user->name }}</strong><br>{{ $order->user->email }}</p>
                <hr>
                <p class="mb-1"><strong>Shipping:</strong></p>
                <p>{{ $order->shipping_name }}<br>
                   {{ $order->shipping_address }}<br>
                   {{ $order->shipping_city }}, {{ $order->shipping_zip }}</p>
                @if($order->notes)
                    <p class="text-muted"><em>{{ $order->notes }}</em></p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Status</h3></div>
            <div class="card-body">
                <p>Current: @include('admin.partials.order-status', ['status' => $order->status])</p>
                <div class="d-flex gap-2 flex-wrap" id="statusBtns">
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                        <button class="btn btn-sm btn-{{ $order->status === $s ? 'primary' : 'outline-secondary' }} btn-status"
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
    const btn    = $(this);
    const status = btn.data('status');
    const url    = btn.data('url');

    $.ajax({
        url,
        type: 'PATCH',
        data: { _token: '{{ csrf_token() }}', status },
        success: function (res) {
            if (res.success) {
                $('#statusBtns .btn-status').removeClass('btn-primary').addClass('btn-outline-secondary');
                btn.removeClass('btn-outline-secondary').addClass('btn-primary');
                toastr.success('Status updated!');
            }
        }
    });
});
</script>
@endpush
