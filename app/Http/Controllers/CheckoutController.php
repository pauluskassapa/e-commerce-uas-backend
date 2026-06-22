<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with(
                'error',
                'Cart kosong'
            );
        }

        $total = 0;

        foreach ($cart->items as $item) {

            $total +=
                $item->price *
                $item->quantity;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'status' => 'pending'
        ]);

        foreach ($cart->items as $item) {

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        $cart->items()->delete();

        return redirect()
            ->route('orders.show',$order)
            ->with(
                'success',
                'Checkout berhasil'
            );
    }
}