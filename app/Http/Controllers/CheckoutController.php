<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Payment;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $cart = auth()->user()->cart()->with('items.product')->first();

            if (!$cart || $cart->items->count() == 0) {
                return;
            }

            $total = $cart->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]);
            }

            Payment::create([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'payment_method_id' => $request->payment_method_id,
                'amount' => $total,
                'status' => 'pending',
                'notes' => 'Menunggu pembayaran',
            ]);

            $cart->items()->delete();
        });

        return redirect()->route('orders.index');
    }
}