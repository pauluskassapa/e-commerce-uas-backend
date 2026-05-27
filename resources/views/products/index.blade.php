@extends('layouts.app')

@section('content')
    <h2>Products</h2>
    <p>TODO: isi fitur list, search, filter kategori, rentang harga, tambah, update, dan hapus produk.</p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category?->name ?? '-' }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada data produk.</td></tr>
        @endforelse
    </table>
@endsection
