@extends('layouts.app')

@section('content')

<h2 class="cart-title">🛒 Keranjang Belanja</h2>

@if(!$cart || $cart->items->isEmpty())

<div class="empty-cart">
    <h2>Cart belum terisi</h2>

<p>Yuk tambahkan produk ke keranjang dahulu.</p>

<a href="{{ route('dashboard') }}"
   class="back-button">
    Kembali ke Produk
</a>

</div>

@else

<div class="select-all-container">
    <input type="checkbox" id="select-all">
    <label for="select-all">
        <strong>Pilih Semua</strong>
    </label>
</div>

@php
$grandTotal = 0;
@endphp

@foreach($cart->items as $item)

@php
    $price = $item->price ?? $item->product->price;
    $subtotal = $price * $item->quantity;
    $grandTotal += $subtotal;
@endphp

<div class="cart-item">

    {{-- Checkbox --}}
    <div>
        <input
            type="checkbox"
            class="item-checkbox"
            data-subtotal="{{ $subtotal }}">
    </div>

    {{-- Gambar Produk --}}
    <div class="cart-image">
        <img
            src="{{ $item->product->image ?? 'https://via.placeholder.com/150' }}"
            alt="{{ $item->product->name }}">
    </div>

    {{-- Informasi Produk --}}
    <div class="cart-info">

        <h3>{{ $item->product->name }}</h3>

        <p>{{ $item->product->description }}</p>

        <p>
            Harga:
            <strong>
                Rp {{ number_format($price,0,',','.') }}
            </strong>
        </p>

        <p>
            Subtotal:
            <strong>
                Rp {{ number_format($subtotal,0,',','.') }}
            </strong>
        </p>

    </div>

    {{-- Quantity --}}
    <div class="cart-quantity">

        <form
            action="{{ route('cart.decrease', $item->product_id) }}"
            method="POST">
            @csrf
            <button type="submit">-</button>
        </form>

        <strong>{{ $item->quantity }}</strong>

        <form
            action="{{ route('cart.increase', $item->product_id) }}"
            method="POST">
            @csrf
            <button type="submit">+</button>
        </form>

    </div>

    {{-- Hapus --}}
    <div>

        <form
            action="{{ route('cart.remove', $item->product_id) }}"
            method="POST">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                onclick="return confirm('Hapus produk dari keranjang?')">
                🗑 Hapus
            </button>

        </form>

    </div>

</div>

@endforeach

<hr>

<div class="cart-footer">

<h2 class="total-price">
    Total Belanja:
    Rp <span id="selected-total">0</span>
</h2>

<a href="{{ route('payments.index') }}"
   class="checkout-button">
    Checkout
</a>

</div>

@endif

<script>

const checkboxes = document.querySelectorAll('.item-checkbox');
const totalElement = document.getElementById('selected-total');
const selectAll = document.getElementById('select-all');

function updateTotal()
{
    let total = 0;

    checkboxes.forEach(cb => {

        if (cb.checked) {

            total += parseInt(cb.dataset.subtotal);

        }

    });

    totalElement.textContent = total.toLocaleString('id-ID');
}

checkboxes.forEach(cb => {

    cb.addEventListener('change', updateTotal);

});

selectAll?.addEventListener('change', function () {

    checkboxes.forEach(cb => {

        cb.checked = this.checked;

    });

    updateTotal();

});

</script>

@endsection
