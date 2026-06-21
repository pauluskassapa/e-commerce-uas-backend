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

    <h3>Rating Produk</h3>

    @php
        $averageRating = $product->averageRating();
        $reviewCount = $product->reviewCount();
    @endphp

    <div class="rating-summary">
        @if ($reviewCount > 0)
            <div class="rating-stars" aria-label="Rating {{ $averageRating }} dari 5">
                @for ($star = 1; $star <= 5; $star++)
                    <span class="{{ $star <= round($averageRating) ? 'star-filled' : 'star-empty' }}">★</span>
                @endfor
            </div>

            <p class="rating-score">{{ $averageRating }}/5</p>
            <p class="rating-count">Berdasarkan {{ $reviewCount }} review pembeli</p>
        @else
            <p class="rating-empty">Belum ada rating untuk produk ini.</p>
        @endif
    </div>

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
