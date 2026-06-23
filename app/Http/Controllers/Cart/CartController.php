<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = Cart::with(['items.product'])
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        return view('carts.index', compact('cart'));
    }

    public function show(Cart $cart): View
    {
        return view('carts.show', compact('cart'));
    }

    public function destroy()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->back()
            ->with('success', 'Cart berhasil dikosongkan');
    }
}
