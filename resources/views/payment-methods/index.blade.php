@extends('layouts.app')

@section('content')
    <h2>Payment Methods</h2>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Provider</th>
            <th>Account Number</th>
            <th>Active</th>
            <th>Action</th>
        </tr>

        @forelse ($methods as $method)
            <tr>
                <td>{{ $method->id }}</td>
                <td>{{ $method->name }}</td>
                <td>{{ $method->provider ?? '-' }}</td>
                <td>{{ $method->account_number ?? '-' }}</td>
                <td>{{ $method->is_active ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('payment-methods.show', $method) }}">
                        Detail
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    Belum ada metode pembayaran.
                </td>
            </tr>
        @endforelse
    </table>
@endsection