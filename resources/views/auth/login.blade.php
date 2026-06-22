@extends('layouts.app')

@section('content')
    <h2>Login Akun</h2>

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
            <span class="password-field">
                <input type="password" name="password" id="login-password" required>
                <button type="button" class="password-toggle" data-target="login-password" aria-label="Lihat password">👁</button>
            </span>
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
