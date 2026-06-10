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

        <button type="submit">Simpan</button>
    </form>
@endsection