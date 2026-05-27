<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    public function index(): View
    {
        return view('payment-methods.index', [
            'methods' => PaymentMethod::latest()->get(),
        ]);
    }

    public function show(PaymentMethod $paymentMethod): View
    {
        return view('payment-methods.show', compact('paymentMethod'));
    }
}
