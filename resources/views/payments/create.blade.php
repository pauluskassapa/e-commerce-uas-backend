@extends('layouts.app')
@section('content')

<h2>Buat Payment</h2>
<form action="{{ route('payments.store') }}" method="POST">
    @csrf
    <label>
        Cart
    </label>
    <br>

    <select name="cart_id">
        <option value="">
            Tidak ada Cart
        </option>
        @foreach($carts as $cart)
            <option value="{{ $cart->id }}">
                Cart #{{ $cart->id }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>
        Payment Method
    </label>
    <br>

    <select name="payment_method_id">
        @foreach($methods as $method)
            <option value="{{ $method->id }}">
                {{ $method->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>
        Amount
    </label>
    <br>

    <input
        type="number"
        step="0.01"
        name="amount"
        required>
    <br><br>

    <button type="submit">
        Buat Payment
    </button>

</form>

@endsection