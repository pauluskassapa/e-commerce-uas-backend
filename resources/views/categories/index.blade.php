@extends('layouts.app')

@section('content')
    <h2>Categories</h2>

    <p>
        @auth
            @if (auth()->user()->role === 'seller')
                <a href="{{ route('categories.create') }}">Tambah Kategori</a>
            @endif
        @endauth
        <a href="{{ route('products.index') }}">Kembali ke Product</a>
    </p>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Total Products</th>
            <th>Action</th>
        </tr>

        @forelse ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->products_count }}</td>
                <td>
                    <a href="{{ route('categories.show', $category) }}">Detail</a>

                    @auth
                        @if (auth()->user()->role === 'seller')
                            <a href="{{ route('categories.edit', $category) }}">Edit</a>

                            <form method="post" action="{{ route('categories.destroy', $category) }}" style="display:inline">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Yakin mau hapus kategori ini?')">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    @endauth
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada data kategori.</td>
            </tr>
        @endforelse
    </table>
@endsection
