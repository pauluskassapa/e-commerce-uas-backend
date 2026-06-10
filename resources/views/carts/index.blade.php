@extends('layouts.app')

@section('content')
<h2>Keranjang Belanja</h2>
    
 
@if($carts->isEmpty())

    <div style="text-align:center; padding:50px;">
        <h2>🛒 Cart belum terisi</h2>

        <p>Yuk tambahkan produk ke keranjang dahulu.</p>

        <a href="{{ route('dashboard') }}"
           style="
                background:green;
                color:white;
                padding:12px 24px;
                border-radius:10px;
                text-decoration:none;">
            Kembali ke produk
        </a>
    </div>

@else

    @foreach($carts as $cart)

        <h3>Cart #{{ $cart->id }}</h3> 

        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($cart->items as $item)

                    <tr>
                        <td>{{ $item->product->name }}</td>

                        <td>Rp {{ number_format($item->product->price) }}</td>

                        <td>
                            <form action="{{ route('cart.decrease', $item->product->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                <button type="submit">-</button>
                            </form>

                            {{ $item->quantity }}

                            <form action="{{ route('cart.increase', $item->product->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                <button type="submit">+</button>
                            </form>
                        </td>

                        <td>
                            <form action="{{ route('cart.remove', $item->product->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                @endforeach

            </tbody>
        </table>

    @endforeach

@endif

@endsection