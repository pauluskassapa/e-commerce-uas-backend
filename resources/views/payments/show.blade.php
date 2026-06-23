@extends('layouts.app')

@section('content')
    <h2>Detail Payment</h2>

    @if (session('success'))
        <p style="color: #15803d;">
            {{ session('success') }}
        </p>
    @endif

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <td>{{ $payment->id }}</td>
        </tr>

        <tr>
            <th>User</th>
            <td>{{ $payment->user?->name ?? '-' }}</td>
        </tr>

        <tr>
            <th>Cart</th>
            <td>{{ $payment->cart?->id ?? '-' }}</td>
        </tr>

        <tr>
            <th>Method</th>
            <td>{{ $payment->method?->name ?? '-' }}</td>
        </tr>

        <tr>
            <th>Amount</th>
            <td>{{ $payment->amount }}</td>
        </tr>

        <tr>
            <th>Alamat Pengiriman</th>
            <td>{{ $payment->shipping_address ?? '-' }}</td>
        </tr>

        <tr>
            <th>Status</th>
            <td>{{ $payment->status }}</td>
        </tr>

        <tr>
            <th>Paid At</th>
            <td>{{ $payment->paid_at ?? '-' }}</td>
        </tr>

        <tr>
            <th>Notes</th>
            <td>{{ $payment->notes ?? '-' }}</td>
        </tr>
    </table>

    <br>

    @if ($payment->cart?->items?->isNotEmpty())
        <h3>Barang</h3>

        <table border="1" cellpadding="6">
            <tr>
                <th>Foto</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>

            @foreach ($payment->cart->items as $item)
                @php
                    $imageUrl = $item->product?->image
                        ? (str_starts_with($item->product->image, 'http')
                            ? $item->product->image
                            : asset(ltrim($item->product->image, '/')))
                        : 'https://via.placeholder.com/80';
                    $price = $item->price ?? $item->product?->price ?? 0;
                    $subtotal = $price * $item->quantity;
                @endphp

                <tr>
                    <td>
                        <img src="{{ $imageUrl }}" alt="{{ $item->product?->name ?? 'Produk' }}" width="70">
                    </td>
                    <td>{{ $item->product?->name ?? 'Produk' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>

        <br>
    @endif

    @if($payment->status === 'pending')
    <form
        action="{{ route('payments.confirm', $payment) }}"method="POST">
        @csrf
        <button type="submit">
            Konfirmasi Pembayaran
        </button>
    </form>
    <br>
    @else
        <a href="{{ route('reviews.create') }}">
            Beri Review Produk
        </a>
        <br><br>
    @endif

    <a href="{{ route('payments.index') }}">
        Kembali ke Daftar Payment
    </a>
@endsection
