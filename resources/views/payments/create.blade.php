@extends('layouts.app')

@section('content')
    <style>
        .payment-page {
            color: #1f2937;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 20px;
            align-items: start;
        }

        .payment-panel {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .payment-panel-header {
            padding: 16px 18px;
            background: #1e293b;
            color: #ffffff;
            font-weight: 700;
        }

        .payment-item {
            display: grid;
            grid-template-columns: 88px minmax(0, 1fr);
            gap: 14px;
            padding: 16px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        .payment-item:last-child {
            border-bottom: 0;
        }

        .payment-item img {
            width: 88px;
            height: 88px;
            border-radius: 8px;
            object-fit: cover;
            background: #f8fafc;
        }

        .payment-item h3 {
            margin: 0 0 8px;
            color: #111827;
        }

        .payment-item p {
            margin: 4px 0;
            color: #4b5563;
        }

        .payment-summary {
            padding: 18px;
        }

        .payment-summary label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .payment-summary select {
            width: 100%;
            min-height: 40px;
            margin-bottom: 16px;
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        .payment-address-note {
            margin: -8px 0 16px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }

        .payment-total {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin: 0 0 18px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            font-size: 18px;
            font-weight: 700;
        }

        .payment-button {
            width: 100%;
            min-height: 42px;
            border: 1px solid #2563eb;
            border-radius: 6px;
            background: #2563eb;
            color: #ffffff;
            font-weight: 700;
            cursor: pointer;
        }

        .payment-button:hover {
            background: #1d4ed8;
        }

        .payment-alert {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #b91c1c;
            font-weight: 700;
        }

        @media (max-width: 780px) {
            .payment-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="payment-page">
        <h1>Pilih Metode Pembayaran</h1>

        @if ($errors->any())
            <div class="payment-alert">
                {{ $errors->first() }}
            </div>
        @endif

        @if (! $selectedCart)
            <p>Cart kosong. Silakan tambahkan produk terlebih dahulu.</p>
            <a href="{{ route('carts.index') }}">Kembali ke cart</a>
        @else
            <div class="payment-grid">
                <div class="payment-panel">
                    <div class="payment-panel-header">Barang yang Dibayar</div>

                    @foreach ($selectedCart->items as $item)
                        @php
                            $imageUrl = $item->product?->image
                                ? (str_starts_with($item->product->image, 'http')
                                    ? $item->product->image
                                    : asset(ltrim($item->product->image, '/')))
                                : 'https://via.placeholder.com/150';
                            $price = $item->price ?? $item->product?->price ?? 0;
                            $subtotal = $price * $item->quantity;
                        @endphp

                        <div class="payment-item">
                            <img src="{{ $imageUrl }}" alt="{{ $item->product?->name ?? 'Produk' }}">
                            <div>
                                <h3>{{ $item->product?->name ?? 'Produk' }}</h3>
                                <p>Qty: {{ $item->quantity }}</p>
                                <p>Harga: Rp {{ number_format($price, 0, ',', '.') }}</p>
                                <p><strong>Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <form class="payment-panel payment-summary" method="post" action="{{ route('payments.store') }}">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{ $selectedCart->id }}">

                    <label for="shipping_address_id">Alamat Pengiriman</label>
                    <select id="shipping_address_id" name="shipping_address_id" required>
                        <option value="">Pilih alamat</option>
                        @foreach ($addresses as $itemAddress)
                            <option value="{{ $itemAddress->id }}" @selected((int) old('shipping_address_id', $address?->id) === $itemAddress->id)>
                                {{ $itemAddress->label }} - {{ $itemAddress->address }}
                            </option>
                        @endforeach
                    </select>

                    <p class="payment-address-note">
                        Alamat bisa diubah atau ditambah dari halaman
                        <a href="{{ route('profiles.index') }}">profile</a>.
                    </p>

                    <label for="payment_method_id">Metode Pembayaran</label>
                    <select id="payment_method_id" name="payment_method_id" required>
                        <option value="">Pilih metode</option>
                        @foreach ($methods as $method)
                            <option value="{{ $method->id }}" @selected((int) old('payment_method_id') === $method->id)>
                                {{ $method->name }} {{ $method->provider ? '- ' . $method->provider : '' }}
                            </option>
                        @endforeach
                    </select>

                    <p class="payment-total">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </p>

                    <button class="payment-button" type="submit">Lanjut Bayar</button>
                </form>
            </div>
        @endif
    </section>
@endsection
