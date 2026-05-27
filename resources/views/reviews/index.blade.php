@extends('layouts.app')

@section('content')
    <h2>Reviews</h2>
    <p>TODO: isi CRUD review, rating, komentar, dan relasi ke produk.</p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Product</th>
            <th>Rating</th>
            <th>Comment</th>
        </tr>
        @forelse ($reviews as $review)
            <tr>
                <td>{{ $review->id }}</td>
                <td>{{ $review->user?->name ?? '-' }}</td>
                <td>{{ $review->product?->name ?? '-' }}</td>
                <td>{{ $review->rating }}</td>
                <td>{{ $review->comment }}</td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada data review.</td></tr>
        @endforelse
    </table>
@endsection
