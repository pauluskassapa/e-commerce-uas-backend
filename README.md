# E-Commerce UAS Backend

Project Laravel MVC untuk lanjutan tugas Backend Programming berdasarkan fitur UTS e-commerce.

## Modul Utama

- Catalog: `Product` dan `Category`
- Account/Auth: `UserProfile` dan `EmailVerificationToken`
- Review: `Review` dan `ReviewReply`
- Cart: `Cart` dan `CartItem`
- Payment: `Payment` dan `PaymentMethod`

Detail pembagian tugas ada di `docs/pembagian-tugas-mvc.md`.

## Menjalankan Project

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Setelah server jalan, buka `http://127.0.0.1:8000`.
