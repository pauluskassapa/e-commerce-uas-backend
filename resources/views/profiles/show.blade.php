@extends('layouts.app')

@section('content')
    <h2>Detail Profil</h2>

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Username:</strong> {{ $profile->username }}</p>
    <p><strong>Role:</strong> {{ ucfirst($profile->role) }}</p>
    <p><strong>No HP:</strong> {{ $profile->phone ?? '-' }}</p>
    <p><strong>Alamat:</strong> {{ $profile->address ?? '-' }}</p>

    <p>
        <a href="{{ route('profiles.index') }}">Kembali ke Profil Saya</a>
    </p>
@endsection
