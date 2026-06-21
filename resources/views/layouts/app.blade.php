<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pendekar Store' }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f4f6f9;
            color: #333;
        }

        header {
            background: #1e293b;
            color: white;
            padding: 20px 40px;
        }

        header h1 {
            margin-bottom: 15px;
        }

        nav {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            transition: 0.3s;
        }

        nav a:hover {
            background: #334155;
        }

        nav span {
            margin-left: auto;
            font-weight: bold;
        }

        nav form button {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        nav form button:hover {
            background: #dc2626;
        }

        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        table th {
            background: #1e293b;
            color: white;
            padding: 12px;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        table tr:hover {
            background: #f8fafc;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .btn-danger {
            background: #ef4444;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-success {
            background: #22c55e;
        }

        .btn-success:hover {
            background: #16a34a;
        }
    </style>
</head>
<body>

<header>
    <h1>⚔️ PENDEKAR STORE</h1>

    <nav>
        <a href="{{ route('dashboard') }}">Home</a>
        <a href="{{ route('products.index') }}">Products</a>
        <a href="{{ route('categories.index') }}">Categories</a>
        <a href="{{ route('reviews.index') }}">Reviews</a>

        @auth
            @if (auth()->user()->role === 'buyer')
                <a href="{{ route('carts.index') }}">Cart</a>
                <a href="{{ route('payments.index') }}">Payments</a>
            @endif

            <a href="{{ route('profiles.index') }}">Profile</a>
        @endauth

        @guest
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('login') }}">Login</a>
        @endguest

        @auth
            <span>
                {{ auth()->user()->name }}
                ({{ auth()->user()->role }})
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endauth
    </nav>
</header>

<main>
    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        @yield('content')
    </div>
</main>

</body>
</html>
