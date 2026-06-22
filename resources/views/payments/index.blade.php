@extends('layouts.app')

@section('content')
    <h1>Daftar Payment</h1>

    <a href="{{ route('payments.create') }}">
        Buat Payment
    </a>

    <br><br>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Cart</th>
            <th>Method</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Paid At</th>
            <th>Action</th>
        </tr>

        @forelse ($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->user?->name ?? '-' }}</td>
                <td>{{ $payment->cart?->id ?? '-' }}</td>
                <td>{{ $payment->method?->name ?? '-' }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->status }}</td>
                <td>{{ $payment->paid_at?->format('d/m/Y H:i') ?? '-' }}</td>
                <td>
                    <a href="{{ route('payments.show', $payment) }}">
                        Detail
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    Belum ada data payment.
                </td>
            </tr>
        @endforelse
    </table>
@endsection