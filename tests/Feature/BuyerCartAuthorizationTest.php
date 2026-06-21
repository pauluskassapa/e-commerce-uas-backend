<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuyerCartAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_add_product_to_cart(): void
    {
        $product = $this->createProduct();

        $this->post("/cart/add/{$product->id}")
            ->assertRedirect('/login');
    }

    public function test_seller_cannot_add_product_to_cart(): void
    {
        $seller = User::create([
            'name' => 'Seller Cart',
            'email' => 'seller-cart@example.com',
            'password' => 'password123',
            'role' => 'seller',
        ]);
        $product = $this->createProduct();

        $this->actingAs($seller)
            ->post("/cart/add/{$product->id}")
            ->assertForbidden();

        $this->assertDatabaseCount('carts', 0);
        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_buyer_can_add_product_to_cart(): void
    {
        $buyer = User::create([
            'name' => 'Buyer Cart',
            'email' => 'buyer-cart@example.com',
            'password' => 'password123',
            'role' => 'buyer',
        ]);
        $product = $this->createProduct();

        $this->actingAs($buyer)
            ->post("/cart/add/{$product->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('carts', [
            'user_id' => $buyer->id,
        ]);
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    private function createProduct(): Product
    {
        return Product::create([
            'name' => 'Produk Cart Test',
            'slug' => 'produk-cart-test-' . uniqid(),
            'description' => 'Produk untuk test cart.',
            'price' => 30000,
            'stock' => 5,
            'is_active' => true,
        ]);
    }
}
