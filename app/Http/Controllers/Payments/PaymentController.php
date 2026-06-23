<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'order', 'method'])->get();

        return view('payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'order', 'method']);

        return view('payments.show', compact('payment'));
    }

    public function confirm(Payment $payment)
    {
        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $payment->order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Payment berhasil dikonfirmasi');
    }
}