@extends('layouts.app')

@section('content')
    <style>
        .profile-grid {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 24px;
            align-items: start;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #1e293b;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            margin: 0 auto 12px;
        }

        .profile-form {
            margin-top: 24px;
            padding: 18px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f8fafc;
        }

        .profile-form label {
            display: block;
            margin: 12px 0 6px;
            font-weight: 700;
        }

        .profile-form input,
        .profile-form textarea {
            width: 100%;
            min-height: 38px;
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        .profile-form textarea {
            min-height: 82px;
            resize: vertical;
        }

        .address-list {
            display: grid;
            gap: 14px;
            margin-top: 12px;
        }

        @media (max-width: 720px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <h2>Profil Saya</h2>

    <div class="profile-grid">
        <div style="text-align:center;">
            <div class="profile-avatar">
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

            <form class="profile-form" method="post" action="{{ route('profiles.update') }}">
                @csrf
                @method('PUT')

                <h3>Edit Data Pengiriman</h3>

                <label for="phone">No HP</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', $profile?->phone) }}">

                <label for="address">Alamat Utama</label>
                <textarea id="address" name="address" required>{{ old('address', $profile?->address) }}</textarea>

                <button class="btn" type="submit">Simpan Profile</button>
            </form>

            <h3 style="margin-top:24px;">Daftar Alamat</h3>

            <div class="address-list">
                @forelse ($addresses as $address)
                    <form class="profile-form" method="post" action="{{ route('profiles.addresses.update', $address) }}">
                        @csrf
                        @method('PUT')

                        <label for="label-{{ $address->id }}">Nama Alamat</label>
                        <input id="label-{{ $address->id }}" type="text" name="label" value="{{ old('label', $address->label) }}" required>

                        <label for="address-{{ $address->id }}">Isi Alamat</label>
                        <textarea id="address-{{ $address->id }}" name="address" required>{{ old('address', $address->address) }}</textarea>

                        <button class="btn" type="submit">Update Alamat</button>
                    </form>
                @empty
                    <p>Belum ada alamat tersimpan.</p>
                @endforelse
            </div>

            <form class="profile-form" method="post" action="{{ route('profiles.addresses.store') }}">
                @csrf

                <h3>Tambah Alamat Baru</h3>

                <label for="new-label">Nama Alamat</label>
                <input id="new-label" type="text" name="label" value="{{ old('label') }}" placeholder="Contoh: Rumah / Kost / Kampus" required>

                <label for="new-address">Isi Alamat</label>
                <textarea id="new-address" name="address" required>{{ old('address') }}</textarea>

                <button class="btn btn-success" type="submit">Tambah Alamat</button>
            </form>
        </div>
    </div>
@endsection
