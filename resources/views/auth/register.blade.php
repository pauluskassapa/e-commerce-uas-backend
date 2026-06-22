@extends('layouts.app')

@section('content')
    <h2>Register Akun Buyer / Seller</h2>

    <style>
        .password-field {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .password-toggle {
            cursor: pointer;
            border: 1px solid #999;
            background: #fff;
            border-radius: 4px;
            padding: 2px 7px;
        }
    </style>

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
            <span class="password-field">
                <input type="password" name="password" id="register-password" required>
                <button type="button" class="password-toggle" data-target="register-password" aria-label="Lihat password">👁</button>
            </span>
        </label>
        @error('password') <p>{{ $message }}</p> @enderror
        <br>

        <label>
            Konfirmasi Password
            <span class="password-field">
                <input type="password" name="password_confirmation" id="register-password-confirmation" required>
                <button type="button" class="password-toggle" data-target="register-password-confirmation" aria-label="Lihat konfirmasi password">👁</button>
            </span>
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

    <script>
        document.querySelectorAll('.password-toggle').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.target);
                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';
                button.textContent = isHidden ? '🙈' : '👁';
                button.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Lihat password');
            });
        });
    </script>
@endsection
