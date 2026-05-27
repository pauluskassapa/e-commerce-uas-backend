<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\View\View;

class CartItemController extends Controller
{
    public function index(): View
    {
        return view('cart-items.index', [
            'items' => CartItem::with(['cart.user', 'product'])->latest()->get(),
        ]);
    }

    public function show(CartItem $cartItem): View
    {
        return view('cart-items.show', compact('cartItem'));
    }
}
