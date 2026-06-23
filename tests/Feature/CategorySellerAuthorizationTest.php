<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorySellerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_create_category_page(): void
    {
        $this->get('/categories/create')
            ->assertRedirect('/login');
    }

    public function test_guest_cannot_store_category(): void
    {
        $this->post('/categories', $this->categoryPayload())
            ->assertRedirect('/login');

        $this->assertDatabaseCount('categories', 0);
    }

    public function test_buyer_cannot_delete_category(): void
    {
        $buyer = User::create([
            'name' => 'Buyer User',
            'email' => 'buyer-category@example.com',
            'password' => 'password123',
            'role' => 'buyer',
        ]);
        $category = Category::create([
            'name' => 'Kategori Test',
            'slug' => 'kategori-test',
        ]);

        $this->actingAs($buyer)
            ->delete("/categories/{$category->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_seller_can_store_category(): void
    {
        $seller = User::create([
            'name' => 'Seller User',
            'email' => 'seller-category@example.com',
            'password' => 'password123',
            'role' => 'seller',
        ]);

        $this->actingAs($seller)
            ->post('/categories', $this->categoryPayload())
            ->assertRedirect('/categories');

        $this->assertDatabaseHas('categories', [
            'name' => 'Kategori Seller Test',
        ]);
    }

    public function test_seller_can_delete_category(): void
    {
        $seller = User::create([
            'name' => 'Seller Delete',
            'email' => 'seller-delete-category@example.com',
            'password' => 'password123',
            'role' => 'seller',
        ]);
        $category = Category::create([
            'name' => 'Kategori Hapus',
            'slug' => 'kategori-hapus',
        ]);

        $this->actingAs($seller)
            ->delete("/categories/{$category->id}")
            ->assertRedirect('/categories');

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    private function categoryPayload(): array
    {
        return [
            'name' => 'Kategori Seller Test',
            'description' => 'Kategori ini hanya boleh dibuat seller.',
        ];
    }
}
