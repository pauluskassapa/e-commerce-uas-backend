<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCategoryPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_shortcut_page_opens_even_when_category_data_is_missing(): void
    {
        $this->get('/products/baju')
            ->assertOk()
            ->assertSee('Baju');

        $this->get('/products/elektronik')
            ->assertOk()
            ->assertSee('Elektronik');
    }
}
