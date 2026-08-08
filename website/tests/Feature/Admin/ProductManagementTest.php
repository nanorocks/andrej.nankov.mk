<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\StoreProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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

        $this->actingAs($customer)
            ->get('/admin/orders')
            ->assertForbidden();
    }

    public function test_owner_can_manage_the_physical_delivery_queue(): void
    {
        $owner = User::factory()->create([
            'email' => 'andrejnankov@gmail.com',
            'email_verified_at' => now(),
        ]);
        $customer = User::factory()->create();
        $product = Product::where('slug', 'startup-signals-board-game')->firstOrFail();

        $order = $customer->orders()->create([
            'status' => Order::STATUS_COMPLETED,
            'total' => $product->price,
            'currency' => $product->currency,
            'requires_shipping' => true,
            'delivery_status' => Order::DELIVERY_READY_TO_SHIP,
            'shipping_name' => 'Elena Petrova',
            'shipping_phone' => '+389 70 123 456',
            'shipping_address_line_1' => 'Partizanski Odredi 10',
            'shipping_city' => 'Skopje',
            'shipping_postal_code' => '1000',
            'shipping_country' => 'MK',
            'completed_at' => now(),
        ]);
        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'paddle_price_id' => 'pri_board_game',
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $this->actingAs($owner)
            ->get('/admin/orders')
            ->assertOk()
            ->assertSee('Orders &amp; delivery', false)
            ->assertSee('Elena Petrova')
            ->assertSee('Ready to ship');

        $this->actingAs($owner)
            ->get("/admin/orders/{$order->id}/edit")
            ->assertOk()
            ->assertSee('Delivery workflow')
            ->assertSee('Partizanski Odredi 10')
            ->assertSee('North Macedonia only');

        Livewire::actingAs($owner)
            ->test(EditOrder::class, ['record' => $order->getRouteKey()])
            ->fillForm(['delivery_status' => Order::DELIVERY_DELIVERED])
            ->call('save')
            ->assertHasNoFormErrors();

        $order->refresh();

        $this->assertSame(Order::DELIVERY_DELIVERED, $order->delivery_status);
        $this->assertNotNull($order->shipped_at);
        $this->assertNotNull($order->delivered_at);
    }

    public function test_owner_can_delete_an_order_and_its_items(): void
    {
        $owner = User::factory()->create([
            'email' => 'andrejnankov@gmail.com',
            'email_verified_at' => now(),
        ]);
        $customer = User::factory()->create();
        $product = Product::where('slug', 'practical-systems-playbook')->firstOrFail();

        $order = $customer->orders()->create([
            'status' => Order::STATUS_COMPLETED,
            'total' => $product->price,
            'currency' => $product->currency,
            'completed_at' => now(),
        ]);
        $item = $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'paddle_price_id' => 'pri_ebook',
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        Livewire::actingAs($owner)
            ->test(EditOrder::class, ['record' => $order->getRouteKey()])
            ->callAction('delete')
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
        $this->assertDatabaseMissing('order_items', ['id' => $item->id]);
    }
}
