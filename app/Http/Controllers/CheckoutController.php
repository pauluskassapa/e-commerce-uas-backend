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

        foreach ($cart->items as $item) {
            if (!$item->product) {
                return back()->with('error', 'Ada produk di cart yang sudah tidak tersedia.');
            }

            if ($item->quantity > $item->product->stock) {
                return back()->with(
                    'error',
                    'Stock ' . $item->product->name . ' kurang. Sisa stock: ' . $item->product->stock
                );
            }
        }

        return redirect()
            ->route('payments.create', ['cart_id' => $cart->id])
            ->with(
                'success',
                'Checkout berhasil. Pilih metode pembayaran.'
            );
    }
}
