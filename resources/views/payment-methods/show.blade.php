@extends('layouts.app')

@section('content')
    <h2>Detail Payment Method</h2>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <td>{{ $paymentMethod->id }}</td>
        </tr>

        <tr>
            <th>Name</th>
            <td>{{ $paymentMethod->name }}</td>
        </tr>

        <tr>
            <th>Provider</th>
            <td>{{ $paymentMethod->provider ?? '-' }}</td>
        </tr>

        <tr>
            <th>Account Number</th>
            <td>{{ $paymentMethod->account_number ?? '-' }}</td>
        </tr>

        <tr>
            <th>Active</th>
            <td>{{ $paymentMethod->is_active ? 'Yes' : 'No' }}</td>
        </tr>

        <tr>
            <th>Created At</th>
            <td>{{ $paymentMethod->created_at }}</td>
        </tr>
    </table>

    <br>

    <a href="{{ route('payment-methods.index') }}">
        Kembali ke Daftar Payment Method
    </a>
@endsection