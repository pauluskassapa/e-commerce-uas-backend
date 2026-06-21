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
        @php
            $imageUrl = str_starts_with($product->image, 'http')
                ? $product->image
                : asset(ltrim($product->image, '/'));
        @endphp

        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" width="200">
    @endif

    <h3>Review Pembeli</h3>

    @forelse ($product->reviews as $review)
        <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
            <p><strong>User:</strong> {{ $review->user?->name ?? 'User' }}</p>
            <p><strong>Rating:</strong> {{ $review->rating }}/5</p>
            <p><strong>Komentar:</strong> {{ $review->comment ?? '-' }}</p>

            @if ($review->replies->count())
                <strong>Balasan Seller:</strong>
                @foreach ($review->replies as $reply)
                    <p>{{ $reply->user?->name ?? 'Seller' }}: {{ $reply->message }}</p>
                @endforeach
            @endif
        </div>
    @empty
        <p>Belum ada review untuk produk ini.</p>
    @endforelse

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
