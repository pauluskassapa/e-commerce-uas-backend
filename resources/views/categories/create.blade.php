@extends('layouts.app')

@section('content')
    <h2>Tambah Kategori</h2>

    <form method="post" action="{{ route('categories.store') }}">
        @csrf

        <label>Nama Kategori
            <input type="text" name="name" value="{{ old('name') }}">
        </label><br>

        <label>Deskripsi
            <textarea name="description">{{ old('description') }}</textarea>
        </label><br>

        <p>
    <button type="submit">Simpan</button>
    <a href="{{ route('categories.index') }}">Kembali</a>
        </p>
    </form>
@endsection