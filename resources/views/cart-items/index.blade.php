@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Shopping Cart</h2>

    @php $grandTotal = 0; @endphp

    @forelse($items as $item)

        @php
            $subtotal = $item->quantity * $item->price;
            $grandTotal += $subtotal;
        @endphp

        <div class="cart-item">

            <div class="cart-image">
                <img src="{{ $item->product->image ?? 'https://via.placeholder.com/150' }}"
                     width="120">
            </div>

            <div class="cart-info">
                <h3>{{ $item->product->name }}</h3>

                <p>
                    {{ $item->product->description }}
                </p>

                <p>
                    Harga:
                    <strong>
                        Rp {{ number_format($item->price,0,',','.') }}
                    </strong>
                </p>
            </div>

            <div class="cart-qty">

                <form action="{{ route('cart.decrease',$item->product_id) }}"
                      method="POST">
                    @csrf
                    <button type="submit">-</button>
                </form>

                <span>{{ $item->quantity }}</span>

                <form action="{{ route('cart.increase',$item->product_id) }}"
                      method="POST">
                    @csrf
                    <button type="submit">+</button>
                </form>

            </div>

            <div class="cart-total">
                Rp {{ number_format($subtotal,0,',','.') }}
            </div>

        </div>

    @empty
        <p>Cart masih kosong.</p>
    @endforelse

    <hr>

    <div class="grand-total">
        <h3>
            Total:
            Rp {{ number_format($grandTotal,0,',','.') }}
        </h3>
    </div>
</div>
@endsection