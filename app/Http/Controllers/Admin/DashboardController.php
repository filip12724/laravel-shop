<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'    => User::count(),
            'products' => Product::count(),
            'orders'   => Order::count(),
            'revenue'  => Order::where('status', '!=', 'cancelled')->sum('total'),
        ];

        $recentOrders = Order::with('user')->orderByDesc('created_at')->limit(5)->get();
        $recentLogs   = ActivityLog::with('user')->orderByDesc('created_at')->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentLogs'));
    }
}
