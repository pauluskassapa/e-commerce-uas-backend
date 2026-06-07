@extends('layouts.app')

@section('content')
    <h2>Register Akun Buyer / Seller</h2>

    <form method="post" action="{{ route('register.store') }}">
        @csrf

        <label>
            Nama
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label>
        @error('name') <p>{{ $message }}</p> @enderror
        <br>

        <label>
            Username
            <input type="text" name="username" value="{{ old('username') }}" required>
        </label>
        @error('username') <p>{{ $message }}</p> @enderror
        <br>

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
            Konfirmasi Password
            <input type="password" name="password_confirmation" required>
        </label>
        <br>

        <label>
            Role
            <select name="role" required>
                <option value="buyer" @selected(old('role', 'buyer') === 'buyer')>Buyer</option>
                <option value="seller" @selected(old('role') === 'seller')>Seller</option>
            </select>
        </label>
        @error('role') <p>{{ $message }}</p> @enderror
        <br>

        <label>
            No HP
            <input type="text" name="phone" value="{{ old('phone') }}">
        </label>
        @error('phone') <p>{{ $message }}</p> @enderror
        <br>

        <label>
            Alamat
            <textarea name="address">{{ old('address') }}</textarea>
        </label>
        @error('address') <p>{{ $message }}</p> @enderror
        <br>

        <button type="submit">Register</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>.</p>
@endsection
