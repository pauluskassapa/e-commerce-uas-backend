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

<<<<<<< HEAD
route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Route::get('/', function () {
//     return 'HALO DANIEL';
// });
=======
Route::redirect('/', '/products')->name('dashboard');
>>>>>>> e9ab497a80e977ff39a0b3bc77286c36c38bdfa9

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

Route::post('/cart/increase/{product}', [CartController::class, 'increase'])
    ->name('cart.increase');

Route::post('/cart/decrease/{product}', [CartController::class, 'decrease'])
    ->name('cart.decrease');

Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])
    ->name('cart.remove');


Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('reviews', ReviewController::class)->only(['index', 'show']);
Route::resource('review-replies', ReviewReplyController::class)->only(['index', 'show']);
Route::resource('carts', CartController::class)->only(['index', 'show']);
Route::resource('cart-items', CartItemController::class)->only(['index', 'show']);
Route::resource('payments', PaymentController::class)->only(['index', 'show']);
Route::resource('payment-methods', PaymentMethodController::class)->only(['index', 'show']);
Route::resource('profiles', ProfileController::class)->only(['index', 'show']);
