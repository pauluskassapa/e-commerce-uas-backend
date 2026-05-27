<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        return view('payments.index', [
            'payments' => Payment::with(['user', 'cart', 'method'])->latest()->get(),
        ]);
    }

    public function show(Payment $payment): View
    {
        return view('payments.show', compact('payment'));
    }
}
