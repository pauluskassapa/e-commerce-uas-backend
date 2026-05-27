@extends('layouts.app')

@section('content')
    <h2>Detail Review</h2>
    <p>Rating: {{ $review->rating }}</p>
    <p>{{ $review->comment }}</p>
@endsection
