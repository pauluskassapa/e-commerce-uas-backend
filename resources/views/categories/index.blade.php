@extends('layouts.app')

@section('content')
    <h2>Categories</h2>
    <p>TODO: isi CRUD kategori untuk pengelompokan produk.</p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Total Products</th>
        </tr>
        @forelse ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->products_count }}</td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada data kategori.</td></tr>
        @endforelse
    </table>
@endsection
