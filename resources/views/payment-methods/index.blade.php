@extends('layouts.app')

@section('content')
    <h2>Payment Methods</h2>
    <p>TODO: isi metode pembayaran seperti transfer bank, e-wallet, atau COD.</p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Provider</th>
            <th>Active</th>
        </tr>
        @forelse ($methods as $method)
            <tr>
                <td>{{ $method->id }}</td>
                <td>{{ $method->name }}</td>
                <td>{{ $method->provider ?? '-' }}</td>
                <td>{{ $method->is_active ? 'Yes' : 'No' }}</td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada metode pembayaran.</td></tr>
        @endforelse
    </table>
@endsection
