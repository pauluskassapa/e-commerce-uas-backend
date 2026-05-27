@extends('layouts.app')

@section('content')
    <h2>Review Replies</h2>
    <p>TODO: isi balasan admin/seller terhadap review user.</p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Review ID</th>
            <th>User</th>
            <th>Message</th>
        </tr>
        @forelse ($replies as $reply)
            <tr>
                <td>{{ $reply->id }}</td>
                <td>{{ $reply->review_id }}</td>
                <td>{{ $reply->user?->name ?? '-' }}</td>
                <td>{{ $reply->message }}</td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada balasan review.</td></tr>
        @endforelse
    </table>
@endsection
