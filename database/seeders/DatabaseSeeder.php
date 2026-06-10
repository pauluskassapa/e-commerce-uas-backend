<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewReply;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $buyer = User::factory()->create([
            'name' => 'Demo Buyer',
            'email' => 'buyer@example.com',
            'role' => 'buyer',
        ]);

        $seller = User::factory()->create([
            'name' => 'Demo Seller',
            'email' => 'seller@example.com',
            'role' => 'seller',
        ]);

        UserProfile::create([
            'user_id' => $buyer->id,
            'username' => 'demo_buyer',
            'role' => 'buyer',
            'phone' => '081234567890',
            'address' => 'Jakarta',
        ]);

        UserProfile::create([
            'user_id' => $seller->id,
            'username' => 'demo_seller',
            'role' => 'seller',
        ]);

        $categories = collect([
    [
        'name' => 'Baju',
        'slug' => 'baju',
        'description' => 'Kategori untuk produk pakaian.',
    ],
    [
        'name' => 'Elektronik',
        'slug' => 'elektronik',
        'description' => 'Kategori untuk produk elektronik.',
    ],
    [
        'name' => 'Makanan & Minuman',
        'slug' => 'makanan-minuman',
        'description' => 'Kategori untuk produk makanan dan minuman.',
    ],
    [
        'name' => 'Aksesoris',
        'slug' => 'aksesoris',
        'description' => 'Kategori untuk aksesoris fashion dan gadget.',
    ],
    [
        'name' => 'Peralatan Rumah',
        'slug' => 'peralatan-rumah',
        'description' => 'Kategori untuk kebutuhan rumah tangga.',
    ],
])->map(fn ($category) => Category::create($category));

$product = Product::create([
    'category_id' => $categories->firstWhere('slug', 'baju')->id,
    'name' => 'Kaos Polos Hitam',
    'slug' => 'kaos-polos-hitam',
    'description' => 'Produk contoh untuk kategori baju.',
    'price' => 75000,
    'stock' => 25,
]);

Product::create([
    'category_id' => $categories->firstWhere('slug', 'elektronik')->id,
    'name' => 'Keyboard Mechanical',
    'slug' => 'keyboard-mechanical',
    'description' => 'Produk contoh untuk kategori elektronik.',
    'price' => 350000,
    'stock' => 10,
]);

Product::create([
    'category_id' => $categories->firstWhere('slug', 'makanan-minuman')->id,
    'name' => 'Kopi Susu Botol',
    'slug' => 'kopi-susu-botol',
    'description' => 'Produk contoh untuk kategori makanan dan minuman.',
    'price' => 18000,
    'stock' => 50,
]);

        $review = Review::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Produk contoh sudah tampil.',
        ]);

        ReviewReply::create([
            'review_id' => $review->id,
            'user_id' => $seller->id,
            'message' => 'Terima kasih atas review-nya.',
        ]);

        $cart = Cart::create([
            'user_id' => $buyer->id,
            'status' => 'active',
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        $method = PaymentMethod::create([
            'name' => 'Transfer Bank',
            'provider' => 'BCA',
            'account_number' => '1234567890',
        ]);

        Payment::create([
            'user_id' => $buyer->id,
            'cart_id' => $cart->id,
            'payment_method_id' => $method->id,
            'amount' => $product->price,
            'status' => 'pending',
        ]);
    }
}
