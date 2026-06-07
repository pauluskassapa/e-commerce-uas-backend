<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pendekar Store' }}</title>
</head>
<body>
    <header>
        <h1>PENDEKAR STORE</h1>
        <nav>
            <a href="{{ route('dashboard') }}">HOME</a>
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('categories.index') }}">Categories</a>
            <a href="{{ route('reviews.index') }}">Reviews</a>
            <a href="{{ route('carts.index') }}">Carts</a>
            <a href="{{ route('payments.index') }}">Payments</a>
            <a href="{{ route('profiles.index') }}">Profiles</a>
        </nav>
        <hr>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
