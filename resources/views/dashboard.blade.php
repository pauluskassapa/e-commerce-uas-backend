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

        .tabel-kategori{
            display:flex;
            gap:30px;
            margin-left:50px;
        }

        .kategori{
            text-align:center;
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
            <a href="{{ route('login') }}" class="button-login">
                Masuk
            </a>

            <a href="{{ route('register') }}" class="button-daftar">
                Daftar
            </a>
        </div>

    </div>

    <div style="margin-left:50px;">
        <h1>Selamat Datang</h1>
        <p>Halaman utama toko online.</p>
    </div>

    <div class = "tabel-kategori">
       
            
              <div class = "kategori">
                    <a href="{{ route('products.by-category', 'baju') }}">
                    <img src = "https://tse2.mm.bing.net/th/id/OIP.Tl425LnCRC-bUDIORYqkbgHaHa?pid=Api&P=0&h=180" width = "150px" height = "150px">
                    </a>
                   <h2>Baju</h2>
               
                </div>
                <div class = "kategori">
                    <a href="{{ route('products.by-category', 'elektronik') }}">
                    <img src = "https://down-id.img.susercontent.com/file/id-50009109-0bd6a9ebd0f2ae9b7e8b9ce7d89897d6@resize_w640_nl.webp" width = "150px" height = "150px">
                    </a>
                    <h2>Elektronik</h2>
                         
                </div>
              
        </div>

</body>
</html>