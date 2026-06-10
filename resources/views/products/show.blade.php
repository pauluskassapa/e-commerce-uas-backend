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
        <a href="{{ route('products.edit', $product) }}">Edit</a>
    </p>
@endsection