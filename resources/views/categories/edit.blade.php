@extends('layouts.app')

@section('content')
    <h2>Edit Kategori</h2>
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