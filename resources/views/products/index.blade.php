@extends('layouts.app')

@section('content')
    <h2>Products</h2>
    
    @if (isset($selectedCategoryName))
        <p>Menampilkan produk kategori: {{ $selectedCategoryName }}</p>
    @endif
    <p>
        @auth
            @if (auth()->user()->role === 'seller')
                <a href="{{ route('products.create') }}">Tambah Product</a>
                <a href="{{ route('categories.index') }}">Kelola Category</a>
            @elseif (auth()->user()->role === 'buyer')
                <a href="{{ route('carts.index') }}">Lihat Cart</a>
            @endif
        @else
            <a href="{{ route('login') }}">Login untuk belanja</a>
        @endauth
    </p>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <h3>Filter Produk</h3>

    <form method="get" action="{{ route('products.index') }}">
        <label>Search
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk">
        </label>

        <label>Kategori
            <select name="category_id">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </label>

        <label>Harga Min
            <input type="number" name="min_price" value="{{ request('min_price') }}">
        </label>

        <label>Harga Max
            <input type="number" name="max_price" value="{{ request('max_price') }}">
        </label>

        <button type="submit">Filter</button>
        <a href="{{ route('products.index') }}">Reset</a>
    </form>

    <br>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        @forelse ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category?->name ?? '-' }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                <td>
                    <a href="{{ route('products.show', $product) }}">Detail</a>

                    @auth
                        @if (auth()->user()->role === 'seller')
                            <a href="{{ route('products.edit', $product) }}">Edit</a>

                            <form method="post" action="{{ route('products.destroy', $product) }}" style="display:inline">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Yakin mau hapus produk ini?')">
                                    Hapus
                                </button>
                            </form>
                        @elseif (auth()->user()->role === 'buyer')
                            <form method="post" action="{{ route('cart.add', $product) }}" style="display:inline">
                                @csrf
                                <button type="submit">Tambah ke Cart</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}">Login untuk Cart</a>
                    @endauth
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Belum ada data produk.</td>
            </tr>
        @endforelse
    </table>
@endsection
