# Pembagian Tugas MVC E-Commerce

Scaffold ini dibuat dari fitur UTS dan requirement tugas lanjutan: PHP, Laravel, MySQL, Github, dan setiap anggota minimal membuat 2 model, 2 controller, dan 2 view.

## Alexander - Review

- Model: `Review`, `ReviewReply`
- Controller: `Reviews/ReviewController`, `Reviews/ReviewReplyController`
- View: `reviews/*`, `review-replies/*`
- Fitur awal: tambah, lihat, detail, update, dan hapus review produk.

## Paulus - Catalog Product

- Model: `Product`, `Category`
- Controller: `Catalog/ProductController`, `Catalog/CategoryController`
- View: `products/*`, `categories/*`
- Fitur awal: list produk, search/filter, detail, tambah, update, patch stok/harga, dan hapus produk.

## Joan - User/Auth

- Model: `UserProfile`, `EmailVerificationToken`
- Controller: `Accounts/AuthController`, `Accounts/ProfileController`
- View: `auth/*`, `profiles/*`
- Fitur awal: register, login, verifikasi email, profile, forgot password, dan reset password.

## Daniel - Cart

- Model: `Cart`, `CartItem`
- Controller: `Cart/CartController`, `Cart/CartItemController`
- View: `carts/*`, `cart-items/*`
- Fitur awal: add item, lihat cart berdasarkan user, update quantity, dan remove item.

## Defrigo - Payment

- Model: `Payment`, `PaymentMethod`
- Controller: `Payments/PaymentController`, `Payments/PaymentMethodController`
- View: `payments/*`, `payment-methods/*`
- Fitur awal: data pembayaran, metode pembayaran, status pembayaran, update, patch, dan hapus.

## Cara Menjalankan

```bash
php artisan migrate --seed
php artisan serve
```

Buka halaman utama Laravel, lalu masuk ke menu dashboard untuk melihat link tiap modul.
