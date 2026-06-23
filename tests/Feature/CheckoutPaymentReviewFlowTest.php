<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutPaymentReviewFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_goes_to_payment_and_paid_product_can_be_reviewed(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = Product::create([
            'name' => 'Produk Flow',
            'slug' => 'produk-flow',
            'price' => 125000,
            'stock' => 5,
            'is_active' => true,
        ]);
        $method = PaymentMethod::create([
            'name' => 'Transfer Bank',
            'provider' => 'BCA',
            'is_active' => true,
        ]);
        $cart = Cart::create([
            'user_id' => $buyer->id,
            'status' => 'active',
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price,
        ]);

        $this->actingAs($buyer)
            ->post('/checkout')
            ->assertRedirect(route('payments.create', ['cart_id' => $cart->id]));

        $this->actingAs($buyer)
            ->get(route('payments.create', ['cart_id' => $cart->id]))
            ->assertOk()
            ->assertSee('Produk Flow')
            ->assertSee('Transfer Bank');

        $this->actingAs($buyer)
            ->post(route('payments.store'), [
                'cart_id' => $cart->id,
                'payment_method_id' => $method->id,
            ])
            ->assertRedirect();

        $payment = Payment::firstOrFail();

        $this->actingAs($buyer)
            ->post(route('payments.confirm', $payment))
            ->assertRedirect(route('payments.index'));

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'status' => 'completed',
        ]);

        $this->actingAs($buyer)
            ->get(route('reviews.create'))
            ->assertOk()
            ->assertSee('Produk Flow');
    }
}
