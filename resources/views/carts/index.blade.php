@extends('layouts.app')

@section('content')
<h2>Keranjang Belanja (Data Dummy)</h2>

@php
    $dummyCarts = [
        (object)[
            'id' => 1,
            'items' => [
                (object)[
                    'product' => (object)[
                        'id' => 1,
                        'name' => 'Laptop Gaming',
                        'price' => 15000000
                    ],
                    'quantity' => 1
                ],
                (object)[
                    'product' => (object)[
                        'id' => 2,
                        'name' => 'Mouse Wireless',
                        'price' => 250000
                    ],
                    'quantity' => 2
                ],
                (object)[
                    'product' => (object)[
                        'id' => 3,
                        'name' => 'Keyboard Mechanical',
                        'price' => 750000
                    ],
                    'quantity' => 1
                ]
            ]
        ]
    ];
@endphp

@foreach($dummyCarts as $cart)

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

                    <td>
                        Rp {{ number_format($item->product->price) }}
                    </td>

                    <td>
                        <button>-</button>

                        {{ $item->quantity }}

                        <button>+</button>
                    </td>

                    <td>
                        <button>Hapus</button>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>

@endforeach

@endsection