@extends('layouts.app')

@section('content')
<h1>Daftar Order</h1>

<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Total</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($orders as $order)
    <tr>
        <td>#{{ $order->id }}</td>
        <td>{{ $order->total_amount }}</td>
        <td>{{ $order->status }}</td>
        <td>
            <a href="{{ route('orders.show', $order) }}">
                Detail
            </a>
        </td>
    </tr>
    @endforeach
</table>
@endsection