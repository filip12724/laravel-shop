<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMail;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"));
        }

        $orders = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    public static function allowedTransitions(): array
    {
        return [
            'pending'    => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped'    => ['delivered', 'cancelled'],
            'delivered'  => [],
            'cancelled'  => [],
        ];
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);

        $allowed = self::allowedTransitions()[$order->status] ?? [];
        if (!in_array($request->status, $allowed)) {
            return response()->json(['success' => false, 'message' => 'Invalid status transition.'], 422);
        }

        $previousStatus = $order->status;
        $order->update(['status' => $request->status]);

        if ($request->status === 'cancelled' && $previousStatus !== 'cancelled') {
            $order->load('items');
            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)->increment('stock', $item->quantity);
            }
        }

        ActivityLog::log('order_status_updated', "Order #{$order->id} status changed to '{$request->status}'");

        // Notify all orders by email on every status change
        $email = $order->user?->email ?? $order->guest_email;
        if ($email) {
            try {
                $order->load('items.product');
                $cancelReason = $request->status === 'cancelled' ? $request->input('cancel_reason') : null;
                Mail::to($email)->send(new OrderStatusMail($order, $cancelReason));
            } catch (\Exception $e) {
                \Log::error("Order #{$order->id} status mail failed: " . $e->getMessage());
            }
        }

        return response()->json(['success' => true, 'status' => $order->status]);
    }
}
