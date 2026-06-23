<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $user = $request->user();
        $address = $this->firstOrCreateAddress($user);
        $addresses = $user->addresses()
            ->orderByDesc('is_default')
            ->oldest()
            ->get();

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
                'total',
                'addresses',
                'address'
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
            'shipping_address_id' => [
                'nullable',
                Rule::exists('user_addresses', 'id')->where('user_id', auth()->id()),
            ],
        ]);

        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->findOrFail($request->cart_id);

        if ($cart->items->isEmpty()) {
            return back()
                ->withErrors(['cart_id' => 'Cart kosong.'])
                ->withInput();
        }

        $stockError = $this->stockError($cart);

        if ($stockError) {
            return back()
                ->withErrors(['cart_id' => $stockError])
                ->withInput();
        }

        $address = UserAddress::where('user_id', auth()->id())
            ->find($request->shipping_address_id)
            ?? $this->firstOrCreateAddress($request->user());

        if (!$address) {
            return back()
                ->withErrors(['shipping_address_id' => 'Tambahkan alamat pengiriman dulu di profile.'])
                ->withInput();
        }

        $total = $cart->items->sum(fn ($item) => $item->price * $item->quantity);

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'cart_id' => $cart->id,
            'payment_method_id' => $request->payment_method_id,
            'amount' => $total,
            'shipping_address' => $address->address,
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

        $result = DB::transaction(function () use ($payment) {
            $payment->load('cart.items.product');

            if ($payment->status === 'paid') {
                return null;
            }

            if (!$payment->cart || $payment->cart->items->isEmpty()) {
                return 'Cart tidak ditemukan atau kosong.';
            }

            $stockError = $this->stockError($payment->cart);

            if ($stockError) {
                return $stockError;
            }

            foreach ($payment->cart->items as $item) {
                $item->product->decrement('stock', $item->quantity);
            }

            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
                'notes' => 'Pembayaran berhasil',
            ]);

            $payment->cart->update([
                'status' => 'completed',
            ]);

            return null;
        });

        if ($result) {
            return back()->with('error', $result);
        }

        return redirect()
            ->route(
                'payments.index'
            )
            ->with('success', 'Pembayaran berhasil.');
    }

    private function firstOrCreateAddress(User $user): ?UserAddress
    {
        $user->loadMissing('profile');

        $address = $user->addresses()
            ->orderByDesc('is_default')
            ->oldest()
            ->first();

        if ($address) {
            return $address;
        }

        return $user->addresses()->create([
            'label' => 'Alamat Utama',
            'address' => $user->profile?->address ?: 'Alamat belum diisi',
            'is_default' => true,
        ]);
    }

    private function stockError(Cart $cart): ?string
    {
        foreach ($cart->items as $item) {
            if (!$item->product) {
                return 'Ada produk yang sudah tidak tersedia.';
            }

            if ($item->quantity > $item->product->stock) {
                return 'Stock ' . $item->product->name . ' kurang. Sisa stock: ' . $item->product->stock;
            }
        }

        return null;
    }
}
