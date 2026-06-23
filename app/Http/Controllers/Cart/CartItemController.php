<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    public function store(Product $product)
    {
        if ($product->stock < 1) {
            return redirect()->back()
                ->with('error', 'Stock ' . $product->name . ' kosong.');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'status' => 'active',
        ]);

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            if ($item->quantity + 1 > $product->stock) {
                return redirect()->back()
                    ->with('error', 'Stock ' . $product->name . ' kurang. Stok tinggal ' . $product->stock);
            }

            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function increase(Product $product)
    {
        $cart = $this->activeCart();

        if (!$cart) {
            return redirect()->back();
        }

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            if ($item->quantity + 1 > $product->stock) {
                return redirect()->back()
                    ->with('error', 'Stock ' . $product->name . ' kurang. Stok tinggal ' . $product->stock);
            }

            $item->increment('quantity');
        }

        return redirect()->back();
    }

    public function decrease(Product $product)
    {
        $cart = $this->activeCart();

        if (!$cart) {
            return redirect()->back();
        }

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            }
             else {
            return redirect()->back()
                ->with('error', 'harus ada jumlah barangnya minimal 1');
        }

        }

        return redirect()->back();
    }

    public function destroy(Product $product)
    {
        $cart = $this->activeCart();

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
                ->with('success', 'Produk berhasil dihapus');
        }

        return redirect()->back()
            ->with('error', 'Produk tidak ditemukan');
    }

    private function activeCart(): ?Cart
    {
        return Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();
    }
}
