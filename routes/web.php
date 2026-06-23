<?php

use App\Http\Controllers\Accounts\AuthController;
use App\Http\Controllers\Accounts\ProfileController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\CartItemController;
use App\Http\Controllers\Catalog\CategoryController;
use App\Http\Controllers\Catalog\ProductController;
use App\Http\Controllers\Payments\PaymentController;
use App\Http\Controllers\Payments\PaymentMethodController;
use App\Http\Controllers\Reviews\ReviewController;
use App\Http\Controllers\Reviews\ReviewReplyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'buyer'])->group(function () {
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');

    Route::post('/cart/add/{product}', [CartItemController::class, 'store'])->name('cart.add');
    Route::post('/cart/increase/{product}', [CartItemController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease/{product}', [CartItemController::class, 'decrease'])->name('cart.decrease');
    Route::delete('/cart/remove/{product}', [CartItemController::class, 'destroy'])->name('cart.remove');

    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');

    Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])
        ->name('payments.confirm');

    Route::resource('payment-methods', PaymentMethodController::class)
        ->only(['index', 'show']);
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::middleware(['auth', 'seller'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
Route::get('/products/{category:slug}', [ProductController::class, 'byCategory'])
    ->where('category', '^(?!create$)(?![0-9]+$)[A-Za-z0-9-]+$')
    ->name('products.by-category');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::middleware(['auth', 'seller'])->group(function () {
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

Route::middleware(['auth', 'buyer'])->group(function () {
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
});

Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');

Route::get('/review-replies', [ReviewReplyController::class, 'index'])->name('review-replies.index');

Route::middleware(['auth', 'seller'])->group(function () {
    Route::post('/review-replies', [ReviewReplyController::class, 'store'])->name('review-replies.store');
    Route::get('/review-replies/{reviewReply}/edit', [ReviewReplyController::class, 'edit'])->name('review-replies.edit');
    Route::put('/review-replies/{reviewReply}', [ReviewReplyController::class, 'update'])->name('review-replies.update');
    Route::patch('/review-replies/{reviewReply}', [ReviewReplyController::class, 'update'])->name('review-replies.update');
});

Route::get('/review-replies/{reviewReply}', [ReviewReplyController::class, 'show'])->name('review-replies.show');

Route::resource('profiles', ProfileController::class)
    ->only(['index', 'show'])
    ->middleware('auth');
