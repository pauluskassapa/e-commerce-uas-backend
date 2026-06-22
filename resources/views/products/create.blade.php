@extends('layouts.app')

@section('content')
    <h2>Tambah Produk</h2>
    @if ($errors->any())
    <div>
        <strong>Data belum valid:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <label>Nama <input type="text" name="name" value="{{ old('name') }}"></label><br>
        <label>Kategori
            <select name="category_id">
                <option value="">Tanpa kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </label><br>
        <label>Harga <input type="number" name="price" value="{{ old('price') }}"></label><br>
        <label>Stok <input type="number" name="stock" value="{{ old('stock') }}"></label><br>
        <label>Gambar Produk</label>
        <label class="upload-box" for="product-image">
            <span class="upload-plus">+</span>
            <span class="upload-text">Tambahkan Foto</span>
            <small>Pilih dari galeri/file</small>
            <img id="image-preview" class="upload-preview" alt="Preview gambar produk">
        </label>
        <input id="product-image" class="upload-input" type="file" name="image" accept="image/*" onchange="previewProductImage(event)">
        <br>

        <label>Deskripsi <textarea name="description">{{ old('description') }}</textarea></label><br>
        <label><input type="checkbox" name="is_active" value="1" checked> Aktif</label><br>

        <p>
            <button type="submit">Simpan</button>
            <a href="{{ route('products.index') }}">Kembali</a>
        </p>
    </form>

    <script>
        function previewProductImage(event) {
            const preview = document.getElementById('image-preview');
            const file = event.target.files[0];

            if (!file) {
                preview.style.display = 'none';
                preview.removeAttribute('src');
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    </script>
@endsection
