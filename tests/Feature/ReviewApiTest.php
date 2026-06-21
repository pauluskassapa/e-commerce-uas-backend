<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_buyer_identity_is_used_when_creating_review(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $otherBuyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createProduct();
        $this->markProductAsPaid($buyer, $product);

        $response = $this->actingAs($buyer)->postJson('/api/review', [
            'user_id' => $otherBuyer->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Produknya bagus.',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('data.user_id', $buyer->id)
            ->assertJsonPath('data.product_id', $product->id);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'rating' => 5,
        ]);
    }

    public function test_only_owner_can_update_review(): void
    {
        $owner = User::factory()->create(['role' => 'buyer']);
        $otherBuyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createProduct();
        $review = Review::create([
            'user_id' => $owner->id,
            'product_id' => $product->id,
            'rating' => 3,
            'comment' => 'Review awal.',
        ]);

        $this->actingAs($otherBuyer)->patchJson("/api/review/{$review->id}", [
            'rating' => 1,
        ])->assertForbidden();

        $this->actingAs($owner)->patchJson("/api/review/{$review->id}", [
            'rating' => 5,
            'comment' => 'Review diperbarui.',
        ])->assertOk()->assertJsonPath('data.rating', 5);
    }

    public function test_buyer_cannot_review_the_same_product_twice(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createProduct();
        $this->markProductAsPaid($buyer, $product);

        Review::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'rating' => 4,
            'comment' => 'Review pertama.',
        ]);

        $response = $this->actingAs($buyer)->postJson('/api/review', [
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Review kedua.',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors('product_id');
    }

    public function test_buyer_cannot_review_an_unpaid_product(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createProduct();

        $this->actingAs($buyer)->postJson('/api/review', [
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Belum dibayar.',
        ])->assertForbidden()->assertJsonPath(
            'message',
            'Review hanya dapat dibuat setelah produk dibayar.'
        );

        $this->assertDatabaseMissing('reviews', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_only_seller_can_reply_to_review(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $seller = User::factory()->create(['role' => 'seller']);
        $product = $this->createProduct();
        $review = Review::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Produknya bagus.',
        ]);

        $this->actingAs($buyer)->postJson('/api/review-replies', [
            'review_id' => $review->id,
            'message' => 'Balasan buyer.',
        ])->assertForbidden();

        $this->actingAs($seller)->postJson('/api/review-replies', [
            'review_id' => $review->id,
            'message' => 'Terima kasih atas review-nya.',
        ])->assertCreated()->assertJsonPath('data.user_id', $seller->id);
    }

    private function createProduct(): Product
    {
        return Product::create([
            'name' => 'Produk Tes',
            'slug' => 'produk-tes-' . uniqid(),
            'price' => 100000,
            'stock' => 10,
            'is_active' => true,
        ]);
    }

    private function markProductAsPaid(User $buyer, Product $product): void
    {
        $cart = Cart::create([
            'user_id' => $buyer->id,
            'status' => 'completed',
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        Payment::create([
            'user_id' => $buyer->id,
            'cart_id' => $cart->id,
            'amount' => $product->price,
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }
}
