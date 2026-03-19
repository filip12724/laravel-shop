@extends('layouts.app')
@section('title', 'Shopping Cart')

@push('styles')
<style>
    .cart-hero {
        background: linear-gradient(135deg, #280905, #740A03);
        color: #fff;
        border-radius: 8px;
        padding: 18px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .cart-hero i { color: #E6501B; font-size: 1.5rem; }
    .cart-hero h2 { margin: 0; font-size: 1.4rem; }

    /* Items table card */
    .cart-table-card {
        border: none;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 14px rgba(40,9,5,.1);
    }
    .cart-table-card thead tr {
        background: #280905;
        color: #fff;
    }
    .cart-table-card thead th {
        padding: 12px 16px;
        font-size: .8rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        border: none;
    }
    .cart-table-card tbody tr {
        border-bottom: 1px solid #f0e8e7;
        transition: background .15s;
    }
    .cart-table-card tbody tr:last-child { border-bottom: none; }
    .cart-table-card tbody tr:hover { background: #fdf5f4; }
    .cart-table-card tbody td { padding: 14px 16px; border: none; vertical-align: middle; }

    .cart-product-link { color: #280905; font-weight: 600; text-decoration: none; }
    .cart-product-link:hover { color: #C3110C; }

    /* Qty controls */
    .qty-btn {
        width: 28px; height: 28px;
        border: 1.5px solid #C3110C;
        background: transparent;
        color: #C3110C;
        border-radius: 4px;
        font-size: .9rem;
        font-weight: 700;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all .15s;
        flex-shrink: 0;
    }
    .qty-btn:hover { background: #C3110C; color: #fff; }
    .qty-controls { display: flex; align-items: center; gap: 6px; }
    .qty-value {
        width: 40px;
        text-align: center;
        border: 1.5px solid #ddd;
        border-radius: 4px;
        padding: 3px 4px;
        font-size: .9rem;
        font-weight: 600;
        color: #280905;
    }
    .qty-value:focus { border-color: #C3110C; outline: none; }

    .item-price { font-weight: 700; color: #C3110C; font-size: .95rem; }

    .btn-remove {
        background: transparent;
        border: 1.5px solid #e0b0ad;
        color: #C3110C;
        border-radius: 4px;
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all .15s;
        font-size: .8rem;
    }
    .btn-remove:hover { background: #C3110C; color: #fff; border-color: #C3110C; }

    /* Summary card */
    .summary-card {
        border: none;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 14px rgba(40,9,5,.1);
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
    .summary-card .summary-body { padding: 18px; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: .9rem; }
    .summary-row.total-row {
        margin-top: 14px;
        padding-top: 14px;
        border-top: 2px solid #f0e8e7;
        font-weight: 700;
        font-size: 1.1rem;
        color: #280905;
    }
    .summary-row.total-row span:last-child { color: #C3110C; }
    .free-shipping { color: #198754; font-weight: 600; }

    .btn-checkout {
        display: block;
        width: 100%;
        padding: 12px;
        background: #C3110C;
        color: #fff;
        border: none;
        border-radius: 0 0 8px 8px;
        font-weight: 700;
        font-size: .95rem;
        text-align: center;
        text-decoration: none;
        transition: background .2s;
        letter-spacing: .02em;
    }
    .btn-checkout:hover { background: #740A03; color: #fff; }

    .btn-continue {
        padding: 7px 16px;
        border: 1.5px solid #740A03;
        color: #740A03;
        background: transparent;
        border-radius: 4px;
        font-size: .875rem;
        text-decoration: none;
        transition: all .2s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-continue:hover { background: #740A03; color: #fff; }

    /* Empty state */
    .empty-cart { text-align: center; padding: 60px 20px; }
    .empty-cart i { color: #c9a09a; }
    .empty-cart h4 { color: #740A03; margin: 16px 0 8px; }
    .empty-cart p { color: #888; font-size: .9rem; }
</style>
@endpush

@section('content')

<div class="cart-hero">
    <i class="fas fa-shopping-cart"></i>
    <h2>Shopping Cart</h2>
</div>

@if($items->isEmpty())
    <div class="empty-cart">
        <i class="fas fa-shopping-cart fa-4x"></i>
        <h4>Your cart is empty</h4>
        <p>Browse our products and add something you like.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-primary mt-2">
            <i class="fas fa-store me-2"></i>Browse Products
        </a>
    </div>
@else
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="cart-table-card">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr id="cart-row-{{ $item->product->id }}">
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                         width="58" height="58"
                                         style="object-fit:cover; border-radius:6px; border:2px solid #f0e8e7;">
                                @else
                                    <img src="https://picsum.photos/seed/{{ $item->product->id }}/58/58"
                                         width="58" height="58"
                                         style="object-fit:cover;border-radius:6px;border:2px solid #f0e8e7;">
                                @endif
                                <div>
                                    <a href="{{ route('shop.show', $item->product) }}" class="cart-product-link">
                                        {{ $item->product->name }}
                                    </a>
                                    <div style="font-size:.8rem; color:#888; margin-top:2px;">
                                        ${{ number_format($item->product->price, 2) }} each
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="qty-controls">
                                <button class="qty-btn qty-minus" data-id="{{ $item->product->id }}">−</button>
                                <input type="number" class="qty-value qty-input"
                                       value="{{ $item->quantity }}" min="1" max="99"
                                       data-id="{{ $item->product->id }}"
                                       data-url="{{ route('cart.update', $item->product) }}">
                                <button class="qty-btn qty-plus" data-id="{{ $item->product->id }}">+</button>
                            </div>
                        </td>
                        <td>
                            <span class="item-price item-total-{{ $item->product->id }}">
                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn-remove btn-remove-item"
                                    data-url="{{ route('cart.remove', $item->product) }}"
                                    data-id="{{ $item->product->id }}"
                                    title="Remove">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="{{ route('shop.index') }}" class="btn-continue">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="summary-card">
            <div class="summary-header">
                <i class="fas fa-receipt"></i> Order Summary
            </div>
            <div class="summary-body">
                <div class="summary-row">
                    <span style="color:#555;">Subtotal</span>
                    <span id="cartTotal">${{ number_format($total, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span style="color:#555;">Shipping</span>
                    <span class="free-shipping"><i class="fas fa-check-circle me-1" style="font-size:.8rem;"></i>Free</span>
                </div>
                <div class="summary-row total-row">
                    <span>Total</span>
                    <span id="cartTotalFinal">${{ number_format($total, 2) }}</span>
                </div>
            </div>
            <a href="{{ route('checkout') }}" class="btn-checkout">
                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
            </a>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
function updateQty(productId, qty) {
    const url = $(`input.qty-input[data-id="${productId}"]`).data('url');
    $.ajax({
        url, type: 'PATCH',
        data: { _token: '{{ csrf_token() }}', quantity: qty },
        success: function (res) {
            if (res.success) {
                $(`.item-total-${productId}`).text('$' + res.item_total);
                $('#cartTotal, #cartTotalFinal').text('$' + res.cart_total);
                const total = $('input.qty-input').toArray().reduce((s, el) => s + parseInt($(el).val()), 0);
                $('#cartCount').text(total).toggle(total > 0);
            }
        }
    });
}

$(document).on('click', '.qty-minus', function () {
    const id = $(this).data('id');
    const input = $(`input.qty-input[data-id="${id}"]`);
    const val = parseInt(input.val());
    if (val > 1) { input.val(val - 1); updateQty(id, val - 1); }
});

$(document).on('click', '.qty-plus', function () {
    const id = $(this).data('id');
    const input = $(`input.qty-input[data-id="${id}"]`);
    const val = parseInt(input.val());
    input.val(val + 1);
    updateQty(id, val + 1);
});

$(document).on('change', 'input.qty-input', function () {
    const id = $(this).data('id');
    const val = parseInt($(this).val());
    if (val >= 1) updateQty(id, val);
});

$(document).on('click', '.btn-remove-item', function () {
    const url = $(this).data('url');
    const id  = $(this).data('id');
    $.ajax({
        url, type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function (res) {
            if (res.success) {
                $(`#cart-row-${id}`).fadeOut(300, function () {
                    $(this).remove();
                    $('#cartTotal, #cartTotalFinal').text('$' + res.cart_total);
                    const count = parseInt(res.cart_count);
                    if (count === 0) { $('#cartCount').hide(); location.reload(); }
                    else { $('#cartCount').text(count); }
                });
            }
        }
    });
});
</script>
@endpush
