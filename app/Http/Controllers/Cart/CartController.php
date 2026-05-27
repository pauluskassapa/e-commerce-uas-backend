<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return view('carts.index', [
            'carts' => Cart::with(['user', 'items.product'])->latest()->get(),
        ]);
    }

    public function show(Cart $cart): View
    {
        return view('carts.show', compact('cart'));
    }
}
