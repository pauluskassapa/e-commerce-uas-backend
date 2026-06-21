@extends('layouts.app')

@section('content')
    <h2>Detail Review</h2>
    <p><strong>User:</strong> {{ $review->user?->name ?? '-' }}</p>
    <p><strong>Product:</strong> {{ $review->product?->name ?? '-' }}</p>
    <p><strong>Rating:</strong> {{ $review->rating }} / 5</p>
    <p><strong>Comment:</strong> {{ $review->comment ?? '-' }}</p>
    <p><strong>Dibuat:</strong> {{ $review->created_at?->format('d M Y H:i') }}</p>

    <p><a href="{{ route('reviews.index') }}">Kembali ke daftar review</a></p>
@endsection
