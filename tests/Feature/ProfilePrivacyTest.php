<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePrivacyTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_only_shows_logged_in_user_profile(): void
    {
        $buyer = User::create([
            'name' => 'Buyer Saya',
            'email' => 'buyer-profile@example.com',
            'password' => 'password123',
            'role' => 'buyer',
        ]);
        UserProfile::create([
            'user_id' => $buyer->id,
            'username' => 'buyer_saya',
            'role' => 'buyer',
            'phone' => '081111111111',
            'address' => 'Alamat Buyer',
        ]);

        $otherUser = User::create([
            'name' => 'User Lain',
            'email' => 'other-profile@example.com',
            'password' => 'password123',
            'role' => 'seller',
        ]);
        UserProfile::create([
            'user_id' => $otherUser->id,
            'username' => 'user_lain',
            'role' => 'seller',
        ]);

        $this->actingAs($buyer)
            ->get('/profiles')
            ->assertOk()
            ->assertSee('buyer_saya')
            ->assertSee('Alamat Buyer')
            ->assertDontSee('user_lain')
            ->assertDontSee('other-profile@example.com');
    }

    public function test_user_cannot_open_another_user_profile_detail(): void
    {
        $buyer = User::create([
            'name' => 'Buyer Detail',
            'email' => 'buyer-detail@example.com',
            'password' => 'password123',
            'role' => 'buyer',
        ]);
        $seller = User::create([
            'name' => 'Seller Detail',
            'email' => 'seller-detail@example.com',
            'password' => 'password123',
            'role' => 'seller',
        ]);
        $sellerProfile = UserProfile::create([
            'user_id' => $seller->id,
            'username' => 'seller_detail',
            'role' => 'seller',
        ]);

        $this->actingAs($buyer)
            ->get("/profiles/{$sellerProfile->id}")
            ->assertForbidden();
    }
}
