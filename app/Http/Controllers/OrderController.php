<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->orderByDesc('created_at')->paginate(10);
        return view('shop.orders', compact('orders'));
    }

    public function create()
    {
        $cart = CartController::getCart();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items    = collect($cart)->map(fn($qty, $id) => (object)[
            'product'  => $products[$id],
            'quantity' => $qty,
        ])->filter(fn($i) => $i->product !== null);

        $subtotal = $items->sum(fn($i) => $i->product->price * $i->quantity);
        $shipping = $subtotal >= 50 ? 0 : 5.99;
        $total    = $subtotal + $shipping;

        return view('shop.checkout', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $rules = [
            'shipping_name'    => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_city'    => 'required|string|max:100',
            'shipping_zip'     => 'required|string|max:20',
            'notes'            => 'nullable|string|max:500',
        ];

        if (!Auth::check()) {
            $rules['guest_email'] = 'required|email|max:100';
        }

        $validated = $request->validate($rules);

        $cart = CartController::getCart();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $products  = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $subtotal  = array_reduce(array_keys($cart), fn($carry, $id) => $carry + ($products[$id]->price ?? 0) * $cart[$id], 0);
        $shipping  = $subtotal >= 50 ? 0 : 5.99;
        $total     = $subtotal + $shipping;

        $order = Order::create([
            'user_id'          => Auth::id(),
            'guest_email'      => Auth::check() ? null : $request->guest_email,
            'status'           => 'pending',
            'total'            => $total,
            'shipping_name'    => $request->shipping_name,
            'shipping_address' => $request->shipping_address,
            'shipping_city'    => $request->shipping_city,
            'shipping_zip'     => $request->shipping_zip,
            'notes'            => $request->notes,
        ]);

        foreach ($cart as $productId => $qty) {
            if (!isset($products[$productId])) continue;
            $order->items()->create([
                'product_id' => $productId,
                'quantity'   => $qty,
                'price'      => $products[$productId]->price,
            ]);
            $products[$productId]->decrement('stock', $qty);
        }

        session()->forget('cart');

        if (Auth::check()) {
            ActivityLog::log('order_created', "Order #{$order->id} created, total: {$total}");
        }

        if (Auth::check()) {
            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
        }

        return redirect()->route('home')->with('success', "Order #{$order->id} placed! We'll contact you at {$order->guest_email}.");
    }

    public function show(Order $order)
    {
        if (!Auth::check() || $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('shop.order-detail', compact('order'));
    }
}
