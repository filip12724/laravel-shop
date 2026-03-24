@extends('layouts.app')
@section('title', 'Checkout')

@push('styles')
<style>
    .checkout-hero {
        background: linear-gradient(135deg, #280905, #740A03);
        color: #fff;
        border-radius: 8px;
        padding: 18px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .checkout-hero i { color: #E6501B; font-size: 1.5rem; }
    .checkout-hero h2 { margin: 0; font-size: 1.4rem; }

    /* Form card */
    .form-card {
        border: none;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 14px rgba(40,9,5,.1);
    }
    .form-card .form-card-header {
        background: #280905;
        color: #fff;
        padding: 12px 20px;
        font-weight: 700;
        font-size: .85rem;
        letter-spacing: .04em;
        text-transform: uppercase;
        display: flex; align-items: center; gap: 8px;
    }
    .form-card .form-card-header i { color: #E6501B; }
    .form-card .form-card-body { padding: 22px; }

    .form-label { font-weight: 600; font-size: .85rem; color: #740A03; margin-bottom: 5px; }
    .form-control {
        border: 1.5px solid #e0d0cf;
        border-radius: 5px;
        font-size: .9rem;
        padding: 8px 12px;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus {
        border-color: #C3110C;
        box-shadow: 0 0 0 .2rem rgba(195,17,12,.15);
    }
    .guest-notice {
        background: #fdf5f4;
        border: 1px solid #e0b0ad;
        border-radius: 6px;
        padding: 10px 14px;
        font-size: .83rem;
        color: #740A03;
        margin-bottom: 18px;
    }
    .guest-notice a { color: #C3110C; font-weight: 600; }

    /* Summary card */
    .summary-card {
        border: none;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 14px rgba(40,9,5,.1);
        position: sticky;
        top: 20px;
    }
    .summary-card .summary-header {
        background: #280905;
        color: #fff;
        padding: 12px 18px;
        font-weight: 700;
        font-size: .85rem;
        letter-spacing: .04em;
        text-transform: uppercase;
        display: flex; align-items: center; gap: 8px;
    }
    .summary-card .summary-header i { color: #E6501B; }
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 10px 18px;
        border-bottom: 1px solid #f0e8e7;
        font-size: .875rem;
    }
    .summary-item:last-child { border-bottom: none; }
    .summary-item .item-name { color: #444; }
    .summary-item .item-qty { color: #999; font-size: .78rem; margin-left: 4px; }
    .summary-item .item-price { font-weight: 600; color: #280905; }
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 14px 18px;
        background: #f5eeec;
        font-weight: 700;
        font-size: 1rem;
        color: #280905;
        border-top: 2px solid #e0b0ad;
    }
    .summary-total span:last-child { color: #C3110C; font-size: 1.1rem; }

    .btn-place-order {
        display: block;
        width: 100%;
        padding: 13px;
        background: #C3110C;
        color: #fff;
        border: none;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: .03em;
        cursor: pointer;
        transition: background .2s;
        border-radius: 0 0 8px 8px;
        margin-top: 0;
    }
    .btn-place-order:hover { background: #740A03; }

    .required-star { color: #C3110C; }
</style>
@endpush

@section('content')

<div class="checkout-hero">
    <i class="fas fa-credit-card"></i>
    <h2>Checkout</h2>
</div>

<div class="row">
    {{-- Shipping form --}}
    <div class="col-md-7 mb-4">
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-map-marker-alt"></i> Shipping Information
            </div>
            <div class="form-card-body">
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    @if($errors->any())
                        <div style="background:#fdf0f0;border:1px solid #e0b0ad;border-radius:6px;padding:12px 16px;margin-bottom:16px;">
                            <ul style="margin:0;padding-left:18px;font-size:.875rem;color:#740A03;">
                                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    @guest
                    <div class="guest-notice">
                        <i class="fas fa-info-circle me-1"></i>
                        <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">register</a>
                        to track your orders and auto-fill your details.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="required-star">*</span>
                            <span style="font-weight:400;color:#888;font-size:.8rem;">(for order confirmation)</span>
                        </label>
                        <input type="email" name="guest_email"
                               class="form-control @error('guest_email') is-invalid @enderror"
                               value="{{ old('guest_email') }}" required>
                        @error('guest_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endguest

                    @error('cart')<div class="alert alert-danger py-2 mb-3">{{ $message }}</div>@enderror

                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="required-star">*</span></label>
                        <input type="text" name="shipping_name"
                               class="form-control @error('shipping_name') is-invalid @enderror"
                               value="{{ old('shipping_name', auth()->user()?->name) }}" required>
                        @error('shipping_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address <span class="required-star">*</span></label>
                        <input type="text" name="shipping_address"
                               class="form-control @error('shipping_address') is-invalid @enderror"
                               value="{{ old('shipping_address') }}" required
                               placeholder="Street address">
                        @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-8">
                            <label class="form-label">City <span class="required-star">*</span></label>
                            <input type="text" name="shipping_city"
                                   class="form-control @error('shipping_city') is-invalid @enderror"
                                   value="{{ old('shipping_city') }}" required>
                            @error('shipping_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-4">
                            <label class="form-label">ZIP <span class="required-star">*</span></label>
                            <input type="text" name="shipping_zip"
                                   class="form-control @error('shipping_zip') is-invalid @enderror"
                                   value="{{ old('shipping_zip') }}" required>
                            @error('shipping_zip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" style="color:#555;">Notes
                            <span style="font-weight:400;color:#888;font-size:.8rem;">(optional)</span>
                        </label>
                        <textarea name="notes" class="form-control" rows="3"
                                  placeholder="Special delivery instructions...">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn-place-order" style="border-radius:6px;">
                        <i class="fas fa-check-circle me-2"></i>Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Order summary --}}
    <div class="col-md-5">
        <div class="summary-card">
            <div class="summary-header">
                <i class="fas fa-receipt"></i> Order Summary
            </div>
            @foreach($items as $item)
            <div class="summary-item">
                <span>
                    <span class="item-name">{{ $item->product->name }}</span>
                    <span class="item-qty">× {{ $item->quantity }}</span>
                </span>
                <span class="item-price">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
            </div>
            @endforeach
            <div class="summary-item">
                <span style="color:#555;">Subtotal</span>
                <span style="font-weight:600;color:#280905;">${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="summary-item">
                <span style="color:#555;">Shipping</span>
                @if($shipping == 0)
                    <span style="color:#C3110C;font-weight:600;"><i class="fas fa-check-circle me-1" style="font-size:.8rem;"></i>Free</span>
                @else
                    <span style="font-weight:600;color:#280905;">${{ number_format($shipping, 2) }}</span>
                @endif
            </div>
            @if($shipping > 0)
            <div style="padding:6px 18px 10px;font-size:.75rem;color:#888;">
                <i class="fas fa-info-circle me-1"></i>Add ${{ number_format(50 - $subtotal, 2) }} more for free shipping
            </div>
            @endif
            <div class="summary-total">
                <span>Total</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>
</div>

@endsection
