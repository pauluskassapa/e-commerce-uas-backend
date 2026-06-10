<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'E-Commerce MVC' }}</title>
</head>
<body>
    <header>
        <h1>E-Commerce MVC</h1>
        <nav>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('categories.index') }}">Categories</a>
            <a href="{{ route('reviews.index') }}">Reviews</a>
            <a href="{{ route('carts.index') }}">Carts</a>
            <a href="{{ route('payments.index') }}">Payments</a>
            <a href="{{ route('profiles.index') }}">Profiles</a>
            @guest
                <a href="{{ route('register') }}">Register</a>
                <a href="{{ route('login') }}">Login</a>
            @endguest
            @auth
                <span>{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                <form method="post" action="{{ route('logout') }}" style="display: inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @endauth
        </nav>
        <hr>
    </header>

    <main>
        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif

        @yield('content')
    </main>
</body>
</html>
