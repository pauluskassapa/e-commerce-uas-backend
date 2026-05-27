@extends('layouts.app')

@section('content')
    <h2>Payments</h2>
    <p>TODO: isi CRUD pembayaran, status pembayaran, metode, amount, dan relasi user/cart.</p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Method</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
        @forelse ($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->user?->name ?? '-' }}</td>
                <td>{{ $payment->method?->name ?? '-' }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->status }}</td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada data payment.</td></tr>
        @endforelse
    </table>
@endsection
