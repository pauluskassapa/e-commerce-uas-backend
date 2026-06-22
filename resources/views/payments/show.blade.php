@extends('layouts.app')

@section('content')
    <h2>Detail Payment</h2>

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

    @if($payment->status === 'pending')
    <form
        action="{{ route('payments.confirm', $payment) }}"method="POST">
        @csrf
        <button type="submit">
            Konfirmasi Pembayaran
        </button>
    </form>
    <br>
    @endif

    <a href="{{ route('payments.index') }}">
        Kembali ke Daftar Payment
    </a>
@endsection