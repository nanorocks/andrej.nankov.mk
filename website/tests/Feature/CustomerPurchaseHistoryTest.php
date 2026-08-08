<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Laravel\Paddle\Transaction;
use Tests\TestCase;

class CustomerPurchaseHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_order_history(): void
    {
        $this->get(route('orders.index'))->assertRedirect(route('login'));
    }

    public function test_customer_only_sees_their_own_orders(): void
    {
        $customer = User::factory()->create();
        $otherCustomer = User::factory()->create();
        $product = Product::create([
            'name' => 'Private e-book',
            'slug' => 'private-ebook',
            'description' => 'A test digital product.',
            'type' => Product::TYPE_EBOOK,
            'price' => 1900,
            'currency' => 'EUR',
            'paddle_price_id' => 'pri_private_book',
            'is_active' => true,
            'is_coming_soon' => false,
        ]);

        $ownOrder = $this->createOrder($customer, $product, 'Own private purchase');
        $otherOrder = $this->createOrder($otherCustomer, $product, 'Another customer purchase');

        $this->actingAs($customer)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Order #'.$ownOrder->id)
            ->assertSee('Own private purchase')
            ->assertDontSee('Order #'.$otherOrder->id)
            ->assertDontSee('Another customer purchase');
    }

    public function test_order_history_is_paginated_five_orders_at_a_time(): void
    {
        $customer = User::factory()->create();
        $product = Product::create([
            'name' => 'Paginated e-book',
            'slug' => 'paginated-ebook',
            'description' => 'A test digital product.',
            'type' => Product::TYPE_EBOOK,
            'price' => 1900,
            'currency' => 'EUR',
            'paddle_price_id' => 'pri_paginated_book',
            'is_active' => true,
            'is_coming_soon' => false,
        ]);

        foreach (range(1, 6) as $number) {
            $this->createOrder($customer, $product, sprintf('Purchase %02d', $number));
        }

        $this->actingAs($customer)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Purchase 06')
            ->assertSee('Purchase 02')
            ->assertDontSee('Purchase 01')
            ->assertSee('Order history pages');

        $this->actingAs($customer)
            ->get(route('orders.index', ['page' => 2]))
            ->assertOk()
            ->assertSee('Purchase 01')
            ->assertDontSee('Purchase 06');
    }

    public function test_customer_can_resume_or_cancel_their_own_pending_order(): void
    {
        Config::set('cashier.client_side_token', 'test_token');
        Config::set('cashier.api_key', 'test_api_key');

        $customer = User::factory()->create();
        $customer->customer()->create([
            'paddle_id' => 'ctm_pending_order',
            'name' => $customer->name,
            'email' => $customer->email,
        ]);
        $otherCustomer = User::factory()->create();
        $product = Product::create([
            'name' => 'Pending e-book',
            'slug' => 'pending-ebook',
            'description' => 'A pending purchase.',
            'type' => Product::TYPE_EBOOK,
            'price' => 1900,
            'currency' => 'EUR',
            'paddle_price_id' => 'pri_pending_book',
            'is_active' => true,
            'is_coming_soon' => false,
        ]);
        $order = $customer->orders()->create([
            'status' => Order::STATUS_PENDING,
            'total' => $product->price,
            'currency' => $product->currency,
        ]);
        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'paddle_price_id' => $product->paddle_price_id,
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $this->actingAs($customer)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Payment pending')
            ->assertSee('Resume payment')
            ->assertSee('Cancel order');

        $this->actingAs($otherCustomer)
            ->post(route('orders.checkout', $order))
            ->assertNotFound();

        $this->actingAs($customer)
            ->post(route('orders.checkout', $order))
            ->assertOk()
            ->assertSee('Complete your purchase')
            ->assertSee('pri_pending_book', false);

        $this->actingAs($customer)
            ->delete(route('orders.cancel', $order))
            ->assertRedirect(route('orders.index'))
            ->assertSessionHas('success');

        $this->assertSame(Order::STATUS_CANCELLED, $order->refresh()->status);

        $this->actingAs($customer)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Cancelled')
            ->assertDontSee('Resume payment');
    }

    public function test_customer_cannot_cancel_a_paid_order(): void
    {
        $customer = User::factory()->create();
        $product = Product::create([
            'name' => 'Paid e-book',
            'slug' => 'paid-ebook',
            'description' => 'A paid purchase.',
            'type' => Product::TYPE_EBOOK,
            'price' => 1900,
            'currency' => 'EUR',
            'paddle_price_id' => 'pri_paid_book',
            'is_active' => true,
            'is_coming_soon' => false,
        ]);
        $order = $this->createOrder($customer, $product, $product->name);

        $this->actingAs($customer)
            ->delete(route('orders.cancel', $order))
            ->assertRedirect(route('orders.index'))
            ->assertSessionHasErrors('order');

        $this->assertSame(Order::STATUS_COMPLETED, $order->refresh()->status);
    }

    public function test_customer_does_not_see_internal_address_required_status(): void
    {
        $customer = User::factory()->create();
        $product = Product::create([
            'name' => 'Legacy physical order',
            'slug' => 'legacy-physical-order',
            'description' => 'A physical purchase created before local address collection.',
            'type' => Product::TYPE_BOARD_GAME,
            'price' => 3900,
            'currency' => 'EUR',
            'paddle_price_id' => 'pri_legacy_physical',
            'is_active' => true,
            'is_coming_soon' => false,
        ]);
        $order = $customer->orders()->create([
            'status' => Order::STATUS_COMPLETED,
            'total' => $product->price,
            'currency' => $product->currency,
            'requires_shipping' => true,
            'delivery_status' => Order::DELIVERY_ADDRESS_REQUIRED,
            'completed_at' => now(),
        ]);
        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'paddle_price_id' => $product->paddle_price_id,
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $this->actingAs($customer)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Delivery: Preparing delivery')
            ->assertDontSee('Address required');

        $this->actingAs($customer)
            ->get(route('shop.checkout.success', $order))
            ->assertOk()
            ->assertSee('Preparing delivery')
            ->assertDontSee('Address required');
    }

    public function test_profile_only_shows_the_customers_own_transactions(): void
    {
        $customer = User::factory()->create();
        $otherCustomer = User::factory()->create();

        $this->createTransaction($customer, 'txn_customer_123');
        $this->createTransaction($otherCustomer, 'txn_other_456');

        $this->actingAs($customer)
            ->get(route('profile'))
            ->assertOk()
            ->assertSee('Payment transactions')
            ->assertSee('txn_customer_123')
            ->assertDontSee('txn_other_456');
    }

    public function test_customer_profile_uses_the_public_design_system(): void
    {
        $customer = User::factory()->create();

        $this->actingAs($customer)
            ->get(route('profile'))
            ->assertOk()
            ->assertSee('Customer account')
            ->assertSee('Profile &amp; downloads', false)
            ->assertSee('public-form-input', false)
            ->assertSee('public-button-primary', false)
            ->assertSee('id="delete_account_password"', false)
            ->assertSee('placeholder="Enter your current password"', false)
            ->assertSee('z-[70]', false)
            ->assertSee('relative z-10', false)
            ->assertDontSee('bg-base-100', false)
            ->assertDontSee('btn btn-primary', false)
            ->assertDontSee('x-transition', false);
    }

    public function test_owner_can_render_account_navigation_with_admin_link(): void
    {
        $owner = User::factory()->create([
            'email' => 'andrejnankov@gmail.com',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($owner)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Administration')
            ->assertSee(url('/admin'));
    }

    private function createOrder(User $user, Product $product, string $name): Order
    {
        $order = $user->orders()->create([
            'status' => Order::STATUS_COMPLETED,
            'total' => 1900,
            'currency' => 'EUR',
            'completed_at' => now(),
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $name,
            'paddle_price_id' => $product->paddle_price_id,
            'quantity' => 1,
            'unit_price' => 1900,
        ]);

        return $order;
    }

    private function createTransaction(User $user, string $paddleId): Transaction
    {
        return $user->transactions()->create([
            'paddle_id' => $paddleId,
            'status' => Transaction::STATUS_COMPLETED,
            'total' => '1900',
            'tax' => '0',
            'currency' => 'EUR',
            'billed_at' => now(),
        ]);
    }
}
