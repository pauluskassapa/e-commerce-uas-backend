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

Route::view('/', 'dashboard')->name('dashboard');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
Route::resource('reviews', ReviewController::class)->only(['index', 'show']);
Route::resource('review-replies', ReviewReplyController::class)->only(['index', 'show']);
Route::resource('carts', CartController::class)->only(['index', 'show']);
Route::resource('cart-items', CartItemController::class)->only(['index', 'show']);
Route::resource('payments', PaymentController::class)->only(['index', 'show']);
Route::resource('payment-methods', PaymentMethodController::class)->only(['index', 'show']);
Route::resource('profiles', ProfileController::class)->only(['index', 'show']);
