@extends('layouts.app')

@section('content')
    <h2>Register</h2>
    <p>TODO: isi form register akun buyer/seller sesuai endpoint UTS.</p>

    <form method="post" action="#">
        @csrf
        <label>Name <input type="text" name="name"></label><br>
        <label>Email <input type="email" name="email"></label><br>
        <label>Password <input type="password" name="password"></label><br>
        <label>Role <input type="text" name="role" value="buyer"></label><br>
        <button type="submit">Register</button>
    </form>
@endsection
