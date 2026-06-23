<!DOCTYPE html>
<html>
<head>
    <title>TOKO PENDEKAR</title>

    <style>
        body{
            margin:0;
            font-family:Arial, sans-serif;
        }



        .garis{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 40px;
            border-bottom:6px solid #c62424;
            background-color: #1e293b
        }

        .logo{
            font-size:30px;
            font-weight:bold;
            color:White;
        }

        .menu-kanan{
            display:flex;
            gap:10px;
        }

        .button-login{
            padding:8px 20px;
            border:1px solid green;
            color:green;
            background:white;
            border-radius:8px;
            text-decoration:none;
        }

        .button-daftar{
            padding:8px 20px;
            background:green;
            color:white;
            border-radius:8px;
            text-decoration:none;
        }

        .button-logout{
            padding:8px 20px;
            background:#ef4444;
            color:white;
            border:0;
            border-radius:8px;
            cursor:pointer;
        }

        .user-info{
            color:white;
            font-weight:bold;
            align-self:center;
        }

        .tabel-kategori{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap:28px;
            margin:30px 50px;
            max-width:1000px;
        }

        .kategori{
            text-align:center;
        }

        .kategori a{
            display:block;
            text-decoration:none;
            color:#111827;
        }

        .kategori img{
            width:150px;
            height:150px;
            object-fit:cover;
            border-radius:18px;
            border:1px solid #e5e7eb;
            background:#f8fafc;
            box-shadow:0 6px 16px rgba(15,23,42,.12);
            transition:.2s;
        }

        .kategori a:hover img{
            transform:translateY(-3px);
            box-shadow:0 10px 22px rgba(15,23,42,.18);
        }

        .kategori h2{
            margin-top:12px;
            font-size:24px;
        }
    </style>
</head>
<body>

    <div class="garis">

        <div class="logo">      
            <img src = "https://media.licdn.com/dms/image/v2/D5603AQEaaH8bWKgD-A/profile-displayphoto-shrink_200_200/B56Zjhg5zeHcAg-/0/1756130156250?e=2147483647&v=beta&t=nnT1i6FjaRIygiaBSpq-UpuAmqQ8AGiEPKrLuHJnJVQ" width = "50px" height = "50px" style="border-radius: 50%; margin-right: 10px;">
            Pendekar Store
        </div>

        <div class="menu-kanan">
            @guest
                <a href="{{ route('login') }}" class="button-login">
                    Masuk
                </a>

                <a href="{{ route('register') }}" class="button-daftar">
                    Daftar
                </a>
            @endguest

            @auth
                <span class="user-info">
                    {{ auth()->user()->name }} ({{ auth()->user()->role }})
                </span>

                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="button-logout">Logout</button>
                </form>
            @endauth
        </div>

    </div>

    <div style="margin-left:50px;">
        <h1>Selamat Datang</h1>
        <p>Halaman utama toko online.</p>
    </div>

    @php
        $categories = [
            [
                'name' => 'Pakaian',
                'slug' => 'baju',
                'image' => 'assets/categories/pakaian.svg',
            ],
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'image' => 'assets/categories/elektronik.svg',
            ],
            [
                'name' => 'Makanan & Minuman',
                'slug' => 'makanan-minuman',
                'image' => 'assets/categories/makanan-minuman.svg',
            ],
            [
                'name' => 'Aksesoris',
                'slug' => 'aksesoris',
                'image' => 'assets/categories/aksesoris.svg',
            ],
            [
                'name' => 'Peralatan Rumah',
                'slug' => 'peralatan-rumah',
                'image' => 'assets/categories/peralatan-rumah.svg',
            ],
        ];
    @endphp

    <div class="tabel-kategori">
        @foreach ($categories as $category)
            <div class="kategori">
                <a href="{{ route('products.by-category', $category['slug']) }}">
                    <img src="{{ asset($category['image']) }}" alt="{{ $category['name'] }}">
                    <h2>{{ $category['name'] }}</h2>
                </a>
            </div>
        @endforeach
    </div>

</body>
</html>
