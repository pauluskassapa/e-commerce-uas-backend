<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with(
                'error',
                'Cart kosong'
            );
        }

        return redirect()
            ->route('payments.create', ['cart_id' => $cart->id])
            ->with(
                'success',
                'Checkout berhasil. Pilih metode pembayaran.'
            );
    }
}
