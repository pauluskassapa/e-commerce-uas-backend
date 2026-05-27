@extends('layouts.app')

@section('content')
    <h2>Cart Items</h2>
    <p>TODO: isi detail item cart yang terhubung dengan produk.</p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Cart</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
        @forelse ($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->cart_id }}</td>
                <td>{{ $item->product?->name ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada item cart.</td></tr>
        @endforelse
    </table>
@endsection
