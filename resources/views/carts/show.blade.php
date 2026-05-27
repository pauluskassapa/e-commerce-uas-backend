@extends('layouts.app')

@section('content')
    <h2>Detail Cart</h2>
    <p>Cart #{{ $cart->id }} - {{ $cart->status }}</p>
@endsection
