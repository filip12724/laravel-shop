<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Order Status Update</title></head>
<body style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:0;background:#f5f5f5;">

    <!-- Header -->
    <div style="background:linear-gradient(135deg,#280905,#740A03);padding:28px 32px;border-radius:8px 8px 0 0;">
        <h1 style="margin:0;color:#fff;font-size:1.4rem;letter-spacing:.02em;">
            🛒 WildCart
        </h1>
        <p style="margin:6px 0 0;color:#c9a09a;font-size:.875rem;">Order Status Update</p>
    </div>

    <!-- Body -->
    <div style="background:#fff;padding:32px;border-radius:0 0 8px 8px;box-shadow:0 2px 12px rgba(0,0,0,.08);">

        <p style="margin:0 0 16px;color:#333;font-size:.95rem;">
            Hi <strong>{{ $order->shipping_name }}</strong>,
        </p>
        <p style="margin:0 0 24px;color:#555;font-size:.9rem;line-height:1.6;">
            Your order <strong style="color:#280905;">#{{ $order->id }}</strong> has been updated.
            Here's the current status:
        </p>

        <!-- Status badge -->
        @php
            $colors = [
                'pending'    => ['bg' => '#fff3cd', 'color' => '#856404'],
                'processing' => ['bg' => '#cfe2ff', 'color' => '#084298'],
                'shipped'    => ['bg' => '#d1ecf1', 'color' => '#0c5460'],
                'delivered'  => ['bg' => '#d1e7dd', 'color' => '#0a3622'],
                'cancelled'  => ['bg' => '#f8d7da', 'color' => '#58151c'],
            ];
            $c = $colors[$order->status] ?? ['bg' => '#eee', 'color' => '#333'];
        @endphp
        <div style="text-align:center;margin:0 0 28px;">
            <span style="display:inline-block;background:{{ $c['bg'] }};color:{{ $c['color'] }};padding:8px 24px;border-radius:20px;font-weight:700;font-size:1rem;letter-spacing:.04em;">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <!-- Cancel reason -->
        @if($order->status === 'cancelled' && $cancelReason)
        <div style="background:#fef2f2;border-left:4px solid #ef4444;border-radius:6px;padding:14px 16px;margin-bottom:24px;">
            <div style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#ef4444;margin-bottom:4px;">Reason for cancellation</div>
            <div style="font-size:.875rem;color:#555;line-height:1.6;">{{ $cancelReason }}</div>
        </div>
        @endif

        <!-- Order summary -->
        <table style="width:100%;border-collapse:collapse;font-size:.875rem;margin-bottom:24px;">
            <thead>
                <tr style="background:#f5eeec;">
                    <th style="padding:10px 12px;text-align:left;color:#740A03;font-size:.78rem;text-transform:uppercase;letter-spacing:.05em;">Product</th>
                    <th style="padding:10px 12px;text-align:center;color:#740A03;font-size:.78rem;text-transform:uppercase;letter-spacing:.05em;">Qty</th>
                    <th style="padding:10px 12px;text-align:right;color:#740A03;font-size:.78rem;text-transform:uppercase;letter-spacing:.05em;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr style="border-bottom:1px solid #f0e8e7;">
                    <td style="padding:10px 12px;color:#333;">{{ $item->product->name }}</td>
                    <td style="padding:10px 12px;text-align:center;color:#555;">× {{ $item->quantity }}</td>
                    <td style="padding:10px 12px;text-align:right;font-weight:600;color:#280905;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
                @php
                    $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                    $shipping = round($order->total - $subtotal, 2);
                @endphp
                @if($shipping > 0)
                <tr style="border-bottom:1px solid #f0e8e7;">
                    <td colspan="2" style="padding:10px 12px;color:#555;">Shipping</td>
                    <td style="padding:10px 12px;text-align:right;color:#555;">${{ number_format($shipping, 2) }}</td>
                </tr>
                @endif
                <tr style="background:#fdf5f4;">
                    <td colspan="2" style="padding:12px;font-weight:700;color:#280905;">Total</td>
                    <td style="padding:12px;text-align:right;font-weight:800;font-size:1rem;color:#C3110C;">${{ number_format($order->total, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Shipping address -->
        <div style="background:#f9f9f9;border-radius:6px;padding:14px 16px;font-size:.875rem;color:#555;line-height:1.7;">
            <strong style="color:#280905;">Shipping to:</strong><br>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_address }}<br>
            {{ $order->shipping_city }}, {{ $order->shipping_zip }}
        </div>
    </div>

    <!-- Footer -->
    <div style="text-align:center;padding:20px;color:#999;font-size:.78rem;">
        &copy; {{ date('Y') }} WildCart &mdash; All rights reserved.<br>
        This email was sent because you placed an order on WildCart.
    </div>

</body>
</html>
