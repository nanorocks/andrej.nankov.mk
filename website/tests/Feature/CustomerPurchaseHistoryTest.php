<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
