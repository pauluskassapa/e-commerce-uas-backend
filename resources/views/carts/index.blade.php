@extends('layouts.app')

@section('content')

<h2>🛒 Keranjang Belanja</h2>

@if(!$cart || $cart->items->isEmpty())

    <div style="text-align:center; padding:50px;">
        <h2>Cart belum terisi</h2>

        <p>Yuk tambahkan produk ke keranjang dahulu.</p>

        <a href="{{ route('dashboard') }}"
           style="
                background:green;
                color:white;
                padding:12px 24px;
                border-radius:10px;
                text-decoration:none;">
            Kembali ke Produk
        </a>
    </div>

@else

    @php
        $grandTotal = 0;
    @endphp

    @foreach($cart->items as $item)

        @php
            $price = $item->price ?? $item->product->price;
            $subtotal = $price * $item->quantity;
            $grandTotal += $subtotal;
        @endphp

        <div style="
            display:flex;
            gap:20px;
            align-items:center;
            border:1px solid #ddd;
            border-radius:10px;
            padding:15px;
            margin-bottom:15px;
        ">

            {{-- Gambar Produk --}}
            <div>
                <img
                    src="{{ $item->product->image ?? 'https://via.placeholder.com/150' }}"
                    width="120"
                    alt="{{ $item->product->name }}">
            </div>

            {{-- Informasi Produk --}}
            <div style="flex:1;">

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
            <div style="display:flex; align-items:center; gap:10px;">

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

    <div style="text-align:right;">
        <h2>
            Total Belanja:
            Rp {{ number_format($grandTotal,0,',','.') }}
        </h2>
    </div>

@endif

@endsection