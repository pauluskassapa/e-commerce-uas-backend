@extends('layouts.app')

@section('content')
    <h2>Carts</h2>
    <p>TODO: isi fitur tambah produk ke cart, lihat cart per user, update quantity, dan remove item.</p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Status</th>
            <th>Total Items</th>
        </tr>
        @forelse ($carts as $cart)
            <tr>
                <td>{{ $cart->id }}</td>
                <td>{{ $cart->user?->name ?? '-' }}</td>
                <td>{{ $cart->status }}</td>
                <td>{{ $cart->items->count() }}</td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada data cart.</td></tr>
        @endforelse
    </table>
@endsection
