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

//cart

Route::resource('carts', CartController::class)
    ->only(['index', 'show']);

Route::post('/cart/add/{product}', [CartItemController::class, 'store'])
    ->name('cart.add');

Route::post('/cart/increase/{product}', [CartItemController::class, 'increase'])
    ->name('cart.increase');

Route::post('/cart/decrease/{product}', [CartItemController::class, 'decrease'])
    ->name('cart.decrease');

Route::delete('/cart/remove/{product}', [CartItemController::class, 'destroy'])
    ->name('cart.remove');

//catalog

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);

//reviews

Route::resource('reviews', ReviewController::class)
    ->only(['index', 'show']);

Route::resource('review-replies', ReviewReplyController::class)
    ->only(['index', 'show']);

//payment

Route::resource('payments', PaymentController::class)
    ->only(['index', 'show']);

Route::resource('payment-methods', PaymentMethodController::class)
    ->only(['index', 'show']);

//prtofile

Route::resource('profiles', ProfileController::class)
    ->only(['index', 'show']);