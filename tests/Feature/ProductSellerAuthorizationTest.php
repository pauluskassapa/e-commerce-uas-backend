<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSellerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_create_product_page(): void
    {
        $this->get('/products/create')
            ->assertRedirect('/login');
    }

    public function test_guest_cannot_store_product(): void
    {
        $this->post('/products', $this->productPayload())
            ->assertRedirect('/login');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_buyer_cannot_store_product(): void
    {
        $buyer = User::create([
            'name' => 'Buyer User',
            'email' => 'buyer-product@example.com',
            'password' => 'password123',
            'role' => 'buyer',
        ]);

        $this->actingAs($buyer)
            ->post('/products', $this->productPayload())
            ->assertForbidden();

        $this->assertDatabaseCount('products', 0);
    }

    public function test_seller_can_store_product(): void
    {
        $seller = User::create([
            'name' => 'Seller User',
            'email' => 'seller-product@example.com',
            'password' => 'password123',
            'role' => 'seller',
        ]);

        $this->actingAs($seller)
            ->post('/products', $this->productPayload())
            ->assertRedirect('/products');

        $this->assertDatabaseHas('products', [
            'name' => 'Produk Seller Test',
            'price' => 25000,
            'stock' => 10,
        ]);
    }

    public function test_seller_can_open_create_product_page(): void
    {
        $seller = User::create([
            'name' => 'Seller Create',
            'email' => 'seller-create@example.com',
            'password' => 'password123',
            'role' => 'seller',
        ]);

        $this->actingAs($seller)
            ->get('/products/create')
            ->assertOk();
    }

    private function productPayload(): array
    {
        return [
            'name' => 'Produk Seller Test',
            'description' => 'Produk ini hanya boleh dibuat seller.',
            'price' => 25000,
            'stock' => 10,
            'image' => null,
            'is_active' => '1',
        ];
    }
}