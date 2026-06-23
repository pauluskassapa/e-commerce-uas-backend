<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthSellerBuyerTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_register_and_is_logged_in(): void
    {
        $response = $this->post('/register', [
            'name' => 'Buyer Demo',
            'username' => 'buyer_demo',
            'email' => 'buyer@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'buyer',
            'phone' => '081234567890',
            'address' => 'Jl. Buyer No. 1',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'buyer@example.com',
            'role' => 'buyer',
        ]);
        $this->assertDatabaseHas('user_profiles', [
            'username' => 'buyer_demo',
            'role' => 'buyer',
        ]);
    }

    public function test_seller_can_register_and_is_logged_in(): void
    {
        $response = $this->post('/register', [
            'name' => 'Seller Demo',
            'username' => 'seller_demo',
            'email' => 'seller@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'seller',
            'phone' => '081111111111',
            'address' => 'Jl. Seller No. 2',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'seller@example.com',
            'role' => 'seller',
        ]);
        $this->assertDatabaseHas('user_profiles', [
            'username' => 'seller_demo',
            'role' => 'seller',
        ]);
    }

    public function test_register_requires_phone_and_address(): void
    {
        $response = $this->post('/register', [
            'name' => 'No Contact',
            'username' => 'no_contact',
            'email' => 'no-contact@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'seller',
        ]);

        $response->assertSessionHasErrors(['phone', 'address']);
        $this->assertGuest();
        $this->assertDatabaseMissing('users', [
            'email' => 'no-contact@example.com',
        ]);
    }

    public function test_user_can_login_without_selecting_role(): void
    {
        User::create([
            'name' => 'Buyer Login',
            'email' => 'buyer-login@example.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
        ]);

        $response = $this->post('/login', [
            'email' => 'buyer-login@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertSame('buyer', auth()->user()->role);
    }

    public function test_seller_role_is_read_from_saved_account_after_login(): void
    {
        User::create([
            'name' => 'Seller Login',
            'email' => 'seller-login@example.com',
            'password' => Hash::make('password123'),
            'role' => 'seller',
        ]);

        $response = $this->post('/login', [
            'email' => 'seller-login@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertSame('seller', auth()->user()->role);
    }
}
