@extends('layouts.app')

@section('content')
    <h2>Login</h2>
    <p>TODO: isi proses login dan token/session sesuai kebutuhan tugas.</p>

    <form method="post" action="#">
        @csrf
        <label>Email <input type="email" name="email"></label><br>
        <label>Password <input type="password" name="password"></label><br>
        <button type="submit">Login</button>
    </form>
@endsection
