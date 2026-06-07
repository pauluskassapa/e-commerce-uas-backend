@extends('layouts.app')

@section('content')
    <h2>Edit Produk</h2>

    <form method="post" action="{{ route('products.update', $product) }}">
        @csrf
        @method('put')

        <label>Nama <input type="text" name="name" value="{{ old('name', $product->name) }}"></label><br>
        <label>Kategori
            <select name="category_id">
                <option value="">Tanpa kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($product->category_id === $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </label><br>
        <label>Harga <input type="number" name="price" value="{{ old('price', $product->price) }}"></label><br>
        <label>Stok <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"></label><br>
        <label>Gambar <input type="text" name="image" value="{{ old('image', $product->image) }}"></label><br>
        <label>Deskripsi <textarea name="description">{{ old('description', $product->description) }}</textarea></label><br>
        <label><input type="checkbox" name="is_active" value="1" @checked($product->is_active)> Aktif</label><br>

        <button type="submit">Update</button>
    </form>
@endsection