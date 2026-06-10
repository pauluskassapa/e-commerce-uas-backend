<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return view('carts.index', [
        'carts' => Cart::with(['items.product'])
            ->where('user_id', Auth::id())
            ->get(),
    ]);
    }

    public function show(Cart $cart): View
    {
        return view('carts.show', compact('cart'));
    }

    public function add(Product $product)
    {
        
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

       
        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
           
            $item->quantity += 1;
            $item->save();
        } else {
            
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Produk berhasil ditambahkan ke cart');
    }

    public function increase(Product $product)
    {
    $cart = Cart::where('user_id', Auth::id())->first();

    if (!$cart) {
        return redirect()->back();
    }

    $item = $cart->items()
        ->where('product_id', $product->id)
        ->first();

    if ($item) {
        $item->quantity += 1;
        $item->save();
    }

    return redirect()->back();
    }

    public function decrease(Product $product)
{
    $cart = Cart::where('user_id', Auth::id())->first();

    if (!$cart) {
        return redirect()->back();
    }

    $item = $cart->items()
        ->where('product_id', $product->id)
        ->first();

    if ($item) {

        if ($item->quantity > 1) {
            $item->quantity -= 1;
            $item->save();
        } else {
            $item->delete();
        }
    }

    return redirect()->back();
}

    public function remove(Product $product)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return redirect()->back()
                ->with('error', 'Cart tidak ditemukan');
        }

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->delete();
            return redirect()->back()
                ->with('success', 'Produk berhasil dihapus dari cart');
        }

        return redirect()->back()
            ->with('error', 'Produk tidak ditemukan di cart');
    }
}