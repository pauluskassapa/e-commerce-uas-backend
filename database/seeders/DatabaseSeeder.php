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

        $category = Category::create([
            'name' => 'Elektronik',
            'slug' => 'elektronik',
            'description' => 'Kategori contoh untuk katalog produk.',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Keyboard Mechanical',
            'slug' => 'keyboard-mechanical',
            'description' => 'Produk contoh untuk scaffold catalog.',
            'price' => 350000,
            'stock' => 10,
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
