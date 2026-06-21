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

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');


// Authentication


Route::get('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/register', [AuthController::class, 'storeRegister'])
    ->name('register.store');

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'storeLogin'])
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Buyer cart
Route::middleware(['auth', 'buyer'])->group(function () {
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('/cart/add/{product}', [CartItemController::class, 'store'])->name('cart.add');
    Route::post('/cart/increase/{product}', [CartItemController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease/{product}', [CartItemController::class, 'decrease'])->name('cart.decrease');
    Route::delete('/cart/remove/{product}', [CartItemController::class, 'destroy'])->name('cart.remove');
});

// Public catalog, seller management
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::middleware(['auth', 'seller'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
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

Route::resource('reviews', ReviewController::class)->only(['index', 'show']);
Route::resource('review-replies', ReviewReplyController::class)->only(['index', 'show']);
Route::middleware(['auth', 'buyer'])->group(function () {
    Route::resource('payments', PaymentController::class)->only(['index', 'show']);
    Route::resource('payment-methods', PaymentMethodController::class)->only(['index', 'show']);
});
Route::resource('profiles', ProfileController::class)
    ->only(['index', 'show'])
    ->middleware('auth');
