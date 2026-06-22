@extends('layouts.app')

@section('content')
    <h2>Profil Saya</h2>

    <div style="display:grid; grid-template-columns: 180px 1fr; gap:24px; align-items:start;">
        <div style="text-align:center;">
            <div style="width:120px; height:120px; border-radius:50%; background:#1e293b; color:white; display:flex; align-items:center; justify-content:center; font-size:42px; margin:0 auto 12px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <strong>{{ $user->name }}</strong>
            <p>{{ ucfirst($user->role) }}</p>
        </div>

        <div>
            <h3>Informasi Akun</h3>
            <table border="1" cellpadding="8">
                <tr>
                    <th>Nama</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $profile?->username ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $profile?->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $profile?->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Bergabung</th>
                    <td>{{ $user->created_at?->format('d M Y') ?? '-' }}</td>
                </tr>
            </table>

            <h3 style="margin-top:24px;">Akses Fitur</h3>
            @if ($user->role === 'seller')
                <p>Akun seller bisa mengelola produk dan kategori toko.</p>
                <p>
                    <a href="{{ route('products.create') }}" class="btn">Tambah Product</a>
                    <a href="{{ route('categories.index') }}" class="btn">Kelola Category</a>
                </p>
            @else
                <p>Akun buyer bisa melihat katalog, menambahkan produk ke cart, dan melihat payment.</p>
                <p>
                    <a href="{{ route('products.index') }}" class="btn">Belanja</a>
                    <a href="{{ route('carts.index') }}" class="btn">Lihat Cart</a>
                    <a href="{{ route('payments.index') }}" class="btn">Payment</a>
                </p>
            @endif
        </div>
    </div>
@endsection
