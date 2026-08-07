<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\StoreProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(StoreProductSeeder::class);
    }

    public function test_owner_can_manage_store_products_in_filament(): void
    {
        $owner = User::factory()->create([
            'email' => 'andrejnankov@gmail.com',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($owner)
            ->get('/admin/products')
            ->assertOk()
            ->assertSee('Products')
            ->assertSee('Startup Signals')
            ->assertSee('The Practical Systems Playbook');

        $this->actingAs($owner)
            ->get('/admin/products/create')
            ->assertOk()
            ->assertSee('Product details')
            ->assertSee('Pricing and Paddle')
            ->assertSee('Availability');
    }

    public function test_customer_cannot_access_product_management(): void
    {
        $customer = User::factory()->create();

        $this->actingAs($customer)
            ->get('/admin/products')
            ->assertForbidden();
    }
}
