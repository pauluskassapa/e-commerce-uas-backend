<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'user',
            'cart',
            'method'
        ])
        ->latest()
        ->get();

        return view(
            'payments.index',
            compact('payments')
        );
    }

    public function show(Payment $payment)
    {
        $payment->load([
            'user',
            'cart',
            'method'
        ]);

        return view(
            'payments.show',
            compact('payment')
        );
    }

    public function create()
    {
        $methods = PaymentMethod::where(
            'is_active',
            true
        )->get();

        $carts = Cart::all();

        return view(
            'payments.create',
            compact(
                'methods',
                'carts'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart_id' => 'nullable|exists:carts,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:1',
        ]);

        Payment::create([
            'user_id' => auth()->id(),
            'cart_id' => $request->cart_id,
            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount,
            'status' => 'pending',
            'notes' => 'Menunggu pembayaran'
        ]);

        return redirect()
            ->route('payments.index');
    }

    public function confirm(Payment $payment)
    {
        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()
            ->route(
                'payments.show',
                $payment
            );
    }
}