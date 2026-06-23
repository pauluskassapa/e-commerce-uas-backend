@extends('layouts.app')

@section('content')
    <h1>Buat Payment</h1>

    @if ($errors->any())
        <p style="color: #b91c1c;">
            {{ $errors->first() }}
        </p>
    @endif

    <form method="post" action="{{ route('payments.store') }}">
        @csrf

        <p>
            <label for="cart_id">Cart</label><br>
            <select id="cart_id" name="cart_id">
                <option value="">Tanpa cart</option>
                @foreach ($carts as $cart)
                    <option value="{{ $cart->id }}" @selected((int) old('cart_id') === $cart->id)>
                        Cart #{{ $cart->id }} - {{ $cart->status }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="payment_method_id">Metode Payment</label><br>
            <select id="payment_method_id" name="payment_method_id" required>
                <option value="">Pilih metode</option>
                @foreach ($methods as $method)
                    <option value="{{ $method->id }}" @selected((int) old('payment_method_id') === $method->id)>
                        {{ $method->name }} {{ $method->provider ? '- ' . $method->provider : '' }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="amount">Amount</label><br>
            <input id="amount" type="number" name="amount" min="1" value="{{ old('amount') }}" required>
        </p>

        <button type="submit">Simpan Payment</button>
        <a href="{{ route('payments.index') }}">Batal</a>
    </form>
@endsection
