@extends('layouts.app')

@section('content')
    <h2>Detail Kategori</h2>

    <p>Nama: {{ $category->name }}</p>
    <p>Slug: {{ $category->slug }}</p>
    <p>Deskripsi: {{ $category->description ?? '-' }}</p>

    <h3>Produk dalam Kategori Ini</h3>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>

        @forelse ($category->products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada produk dalam kategori ini.</td></tr>
        @endforelse
    </table>
    <p>
    <a href="{{ route('categories.index') }}">Kembali</a>
    <a href="{{ route('categories.edit', $category) }}">Edit</a>
    <a href="{{ route('products.index', ['category_id' => $category->id]) }}">Lihat Produk Kategori Ini</a>
    </p>
@endsection