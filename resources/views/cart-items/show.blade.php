@extends('layouts.app')

@section('content')
    <h2>Detail Cart Item</h2>
    <p>{{ $cartItem->product?->name ?? 'Product belum tersedia' }}</p>
@endsection
