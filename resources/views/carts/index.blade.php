@extends('layouts.app')

@section('content')
    <h2>Carts</h2>
    <p>TODO: isi fitur tambah produk ke cart, lihat cart per user, update quantity, dan remove item.</p>


    @if($carts->isEmpty())

    <div style="text-align:center; padding:50px;">

        <h2>🛒 Cart belum terisi</h2>

        <p>
            Yuk tambahkan produk ke keranjang dahulu.
        </p>

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

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Status</th>
                <th>Total Items</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($carts as $cart)
                <tr>
                    <td>{{ $cart->id }}</td>
                    <td>{{ $cart->user->name ?? '-' }}</td>
                    <td>{{ $cart->status }}</td>
                    <td>{{ $cart->items->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endif

@endsection
