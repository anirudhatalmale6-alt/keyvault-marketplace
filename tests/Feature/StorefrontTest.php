<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_storefront_home_page_loads(): void
    {
        $this->seed();

        $this->get('/')
            ->assertStatus(200)
            ->assertInertia(fn ($page) => $page->component('Storefront/Home'));
    }

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_product_detail_page_loads(): void
    {
        $this->seed();

        $product = \App\Models\Product::active()->firstOrFail();

        $this->get("/product/{$product->slug}")
            ->assertStatus(200)
            ->assertInertia(fn ($page) => $page
                ->component('Storefront/Product')
                ->where('product.name', $product->name));
    }
}
