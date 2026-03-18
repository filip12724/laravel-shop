<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('active', true);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categories = $request->get('categories')) {
            $query->whereIn('category_id', (array) $categories);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        if ($sort = $request->get('sort')) {
            match ($sort) {
                'price_asc'  => $query->orderBy('price'),
                'price_desc' => $query->orderByDesc('price'),
                'newest'     => $query->orderByDesc('created_at'),
                default      => $query->orderBy('name'),
            };
        } else {
            $query->orderBy('name');
        }

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        if ($request->ajax()) {
            return response()->json([
                'html'  => view('partials.product-grid', compact('products'))->render(),
                'pagination' => view('partials.pagination', compact('products'))->render(),
                'total' => $products->total(),
            ]);
        }

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user']);

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('active', true)
            ->limit(4)
            ->get();

        return view('shop.show', compact('product', 'related'));
    }
}
