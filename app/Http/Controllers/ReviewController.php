<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'body'   => 'required|string|min:10|max:1000',
        ]);

        $existing = Review::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existing) {
            return response()->json(['success' => false, 'message' => 'You already reviewed this product.'], 422);
        }

        $review = Review::create([
            'product_id' => $product->id,
            'user_id'    => Auth::id(),
            'rating'     => $request->rating,
            'body'       => $request->body,
        ]);

        $review->load('user');

        ActivityLog::log('review_posted', "Posted review for product '{$product->name}'");

        return response()->json([
            'success' => true,
            'message' => 'Review submitted!',
            'review'  => [
                'user'       => $review->user->name,
                'rating'     => $review->rating,
                'body'       => $review->body,
                'created_at' => $review->created_at->diffForHumans(),
            ],
            'avg_rating' => round($product->reviews()->avg('rating'), 1),
            'total'      => $product->reviews()->count(),
        ]);
    }
}
