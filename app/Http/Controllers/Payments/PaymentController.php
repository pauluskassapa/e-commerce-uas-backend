<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'user',
            'cart',
            'method'
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

        return view(
            'payments.index',
            compact('payments')
        );
    }

    public function show(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $payment->load([
            'user',
            'cart.items.product',
            'method'
        ]);

        return view(
            'payments.show',
            compact('payment')
        );
    }

    public function create(Request $request)
    {
        $methods = PaymentMethod::where(
            'is_active',
            true
        )->get();

        $carts = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->whereHas('items')
            ->latest()
            ->get();

        $selectedCart = $carts->firstWhere('id', (int) $request->query('cart_id'))
            ?? $carts->first();

        $total = $selectedCart
            ? $selectedCart->items->sum(fn ($item) => $item->price * $item->quantity)
            : 0;

        return view(
            'payments.create',
            compact(
                'methods',
                'carts',
                'selectedCart',
                'total'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart_id' => [
                'required',
                Rule::exists('carts', 'id')->where('user_id', auth()->id()),
            ],
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $cart = Cart::with('items')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->findOrFail($request->cart_id);

        if ($cart->items->isEmpty()) {
            return back()
                ->withErrors(['cart_id' => 'Cart kosong.'])
                ->withInput();
        }

        $total = $cart->items->sum(fn ($item) => $item->price * $item->quantity);

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'cart_id' => $cart->id,
            'payment_method_id' => $request->payment_method_id,
            'amount' => $total,
            'status' => 'pending',
            'notes' => 'Menunggu pembayaran'
        ]);

        return redirect()
            ->route('payments.show', $payment)
            ->with('success', 'Payment dibuat. Silakan konfirmasi pembayaran.');
    }

    public function confirm(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
            'notes' => 'Pembayaran berhasil',
        ]);

        $payment->cart?->update([
            'status' => 'completed',
        ]);

        return redirect()
            ->route(
                'payments.index'
            )
            ->with('success', 'Pembayaran berhasil.');
    }
}
