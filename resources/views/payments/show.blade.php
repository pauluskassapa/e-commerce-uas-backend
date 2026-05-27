@extends('layouts.app')

@section('content')
    <h2>Detail Payment</h2>
    <p>Payment #{{ $payment->id }} - {{ $payment->status }}</p>
@endsection
