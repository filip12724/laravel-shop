<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Public shop routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/shop/{product:slug}', [ProductController::class, 'show'])->name('shop.show');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Cart — no login required
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout — no login required (guests can checkout)
Route::get('/checkout', [OrderController::class, 'create'])->name('checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// Auth-required shop routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Reviews
    Route::post('/shop/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', Admin\ProductController::class);
    Route::resource('categories', Admin\CategoryController::class);

    Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/toggle-role', [Admin\UserController::class, 'toggleRole'])->name('users.toggle-role');
    Route::delete('users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('logs', [Admin\ActivityLogController::class, 'index'])->name('logs.index');

    Route::get('messages', [Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{contactMessage}', [Admin\ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{contactMessage}', [Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');
});

require __DIR__.'/auth.php';
