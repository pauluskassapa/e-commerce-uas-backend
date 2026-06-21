@extends('layouts.app')

@section('content')
    <h2>Detail Product</h2>

    <p><strong>Nama:</strong> {{ $product->name }}</p>
    <p><strong>Kategori:</strong> {{ $product->category?->name ?? '-' }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    <p><strong>Stok:</strong> {{ $product->stock }}</p>
    <p><strong>Status:</strong> {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</p>
    <p><strong>Slug:</strong> {{ $product->slug }}</p>
    <p><strong>Deskripsi:</strong> {{ $product->description ?? '-' }}</p>

    @if ($product->image)
        <p><strong>Gambar:</strong></p>
        <img src="{{ $product->image }}" alt="{{ $product->name }}" width="200">
    @endif

    <p>
        <a href="{{ route('products.index') }}">Kembali</a>

        @auth
            @if (auth()->user()->role === 'seller')
                <a href="{{ route('products.edit', $product) }}">Edit</a>
            @endif
        @endauth
    </p>

    @auth
        @if (auth()->user()->role === 'buyer')
            <form method="post" action="{{ route('cart.add', $product) }}">
                @csrf
                <button type="submit">Tambah ke Cart</button>
            </form>
        @endif
    @else
        <p>
            <a href="{{ route('login') }}">Login dulu untuk tambah produk ke cart</a>
        </p>
    @endauth
@endsection
