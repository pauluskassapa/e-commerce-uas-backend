@extends('layouts.app')

@section('content')
    <h2>User Profiles</h2>
    <p>TODO: isi profile user, verifikasi email, forgot password, dan reset password.</p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Username</th>
            <th>Role</th>
        </tr>
        @forelse ($profiles as $profile)
            <tr>
                <td>{{ $profile->id }}</td>
                <td>{{ $profile->user?->name ?? '-' }}</td>
                <td>{{ $profile->username }}</td>
                <td>{{ $profile->role }}</td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada profile user.</td></tr>
        @endforelse
    </table>
@endsection
