@extends('layouts.app')

@section('content')
    <h2>Login Akun</h2>

    <form method="post" action="{{ route('login.store') }}">
        @csrf

        <label>
            Email
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        @error('email') <p>{{ $message }}</p> @enderror
        <br>

        <label>
            Password
            <input type="password" name="password" required>
        </label>
        @error('password') <p>{{ $message }}</p> @enderror
        <br>

        <label>
            <input type="checkbox" name="remember" value="1">
            Ingat saya
        </label>
        <br>

        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="{{ route('register') }}">Register di sini</a>.</p>
@endsection
