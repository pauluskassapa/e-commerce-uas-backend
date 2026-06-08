@extends('layouts.app')

@section('content')
    <h1>Detail Payment</h1>

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
            <th>Payment Method</th>
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
            <td>{{ $payment->paid_at?->format('d/m/Y H:i') ?? '-' }}</td>
        </tr>

        <tr>
            <th>Notes</th>
            <td>{{ $payment->notes ?? '-' }}</td>
        </tr>

        <tr>
            <th>Created At</th>
            <td>{{ $payment->created_at?->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <br>

    <a href="{{ route('payments.index') }}">
        Kembali ke Daftar Payment
    </a>
@endsection