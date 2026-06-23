@extends('layouts.app')

@section('content')
    <h2>Edit Produk</h2>
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

    <form method="post" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
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
      <label>

    Harga
<input

        id="price-display"

        type="text"

        value="{{ old('price') ? 'Rp ' . number_format(old('price'), 0, ',', '.') : '' }}"

        placeholder="Rp {{ number_format($product->price, 0, ',', '.') }}"

        inputmode="numeric"
>
<input id="price" type="hidden" name="price" value="{{ old('price') }}">
</label><br>
 
        <label>Stok <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"></label><br>
        <label>Gambar Produk</label>
        <label class="upload-box" for="product-image">
            <span class="upload-plus">+</span>
            <span class="upload-text">Ganti Foto</span>
            <small>Pilih dari galeri/file</small>

            @if ($product->image)
                @php
                    $imageUrl = str_starts_with($product->image, 'http')
                        ? $product->image
                        : (str_starts_with($product->image, 'products/')
                            ? asset('storage/' . $product->image)
                            : asset(ltrim($product->image, '/')));
                @endphp

                <img id="image-preview" class="upload-preview" src="{{ $imageUrl }}" alt="Preview gambar produk" style="display: block;">
            @else
                <img id="image-preview" class="upload-preview" alt="Preview gambar produk">
            @endif
        </label>
        <input id="product-image" class="upload-input" type="file" name="image" accept="image/*" onchange="previewProductImage(event)">
        <br>

        <label>Deskripsi <textarea name="description">{{ old('description', $product->description) }}</textarea></label><br>
        <label><input type="checkbox" name="is_active" value="1" @checked($product->is_active)> Aktif</label><br>

        <p>
            <button type="submit">Update</button>
            <a href="{{ route('products.index') }}">Kembali</a>
        </p>
    </form>

    <script>
        function previewProductImage(event) {
            const preview = document.getElementById('image-preview');
            const file = event.target.files[0];

            if (!file) {
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
        function formatRupiah(value) {
        const number = value.replace(/\D/g, '');

        if (!number) {
            return '';
        }

        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    const priceDisplay = document.getElementById('price-display');
    const priceInput = document.getElementById('price');

    priceDisplay.addEventListener('input', function () {
        const number = this.value.replace(/\D/g, '');

        this.value = formatRupiah(this.value);
        priceInput.value = number;
    });
    </script>
@endsection
