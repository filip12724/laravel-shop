<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /** Get cart from session: ['product_id' => quantity, ...] */
    public static function getCart(): array
    {
        return session()->get('cart', []);
    }

    public static function cartCount(): int
    {
        return array_sum(self::getCart());
    }

    public function index()
    {
        $cart     = self::getCart();
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = collect($cart)->map(fn($qty, $id) => (object)[
            'product'  => $products[$id] ?? null,
            'quantity' => $qty,
        ])->filter(fn($item) => $item->product !== null)->values();

        $total = $items->sum(fn($item) => $item->product->price * $item->quantity);

        return view('shop.cart', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'integer|min:1|max:99']);

        $quantity = (int) $request->get('quantity', 1);
        $cart     = self::getCart();

        $cart[$product->id] = ($cart[$product->id] ?? 0) + $quantity;
        session()->put('cart', $cart);

        if (Auth::check()) {
            ActivityLog::log('cart_add', "Added '{$product->name}' (qty: {$quantity}) to cart");
        }

        return response()->json([
            'success'    => true,
            'message'    => "'{$product->name}' added to cart!",
            'cart_count' => self::cartCount(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $cart = self::getCart();
        $cart[$product->id] = $request->quantity;
        session()->put('cart', $cart);

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $total    = array_reduce(array_keys($cart), fn($carry, $id) => $carry + ($products[$id]->price ?? 0) * $cart[$id], 0);

        return response()->json([
            'success'    => true,
            'item_total' => number_format(($products[$product->id]->price ?? 0) * $request->quantity, 2),
            'cart_total' => number_format($total, 2),
        ]);
    }

    public function remove(Product $product)
    {
        $cart = self::getCart();
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $total    = array_reduce(array_keys($cart), fn($carry, $id) => $carry + ($products[$id]->price ?? 0) * $cart[$id], 0);

        return response()->json([
            'success'    => true,
            'cart_count' => self::cartCount(),
            'cart_total' => number_format($total, 2),
        ]);
    }
}
