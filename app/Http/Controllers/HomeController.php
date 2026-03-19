<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured   = Product::with('category')
            ->where('active', true)
            ->latest()
            ->limit(8)
            ->get();

        $categories = Category::withCount(['products' => fn ($q) => $q->where('active', true)])
            ->having('products_count', '>', 0)
            ->get();

        $totalProducts = Product::where('active', true)->count();

        return view('home', compact('featured', 'categories', 'totalProducts'));
    }
}
