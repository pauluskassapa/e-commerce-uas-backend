@extends('layouts.app')

@section('content')
    <h2>Edit Kategori</h2>

    <form method="post" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('put')

        <label>Nama Kategori
            <input type="text" name="name" value="{{ old('name', $category->name) }}">
        </label><br>

        <label>Deskripsi
            <textarea name="description">{{ old('description', $category->description) }}</textarea>
        </label><br>

        <button type="submit">Update</button>
    </form>
@endsection