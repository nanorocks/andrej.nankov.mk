<?php

namespace Tests\Feature;

use App\Listeners\CompleteStoreOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\SocialLinksSeeder;
use Database\Seeders\StoreProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Laravel\Paddle\Events\TransactionCompleted;
use Laravel\Paddle\Transaction;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            StoreProductSeeder::class,
            SocialLinksSeeder::class,
        ]);
    }

    public function test_shop_displays_two_coming_soon_products_and_brand_assets(): void
    {
        $this->get(route('shop.index'))
            ->assertOk()
            ->assertSee('Startup Signals')
            ->assertSee('The Practical Systems Playbook')
            ->assertSee('Coming soon')
            ->assertSee('assets/avatars/personal_logo_notes_nankov.png', false)
            ->assertSee('Visit Andrej Nankov on Medium')
            ->assertSee('https://medium.com/@nanorocks', false);
    }

    public function test_coming_soon_products_cannot_be_added_to_the_cart(): void
    {
        $product = Product::where('slug', 'startup-signals-board-game')->firstOrFail();

        $this->from(route('shop.index'))
            ->post(route('shop.cart.store', $product))
            ->assertRedirect(route('shop.index'))
            ->assertSessionHasErrors('cart');

        $this->get(route('shop.cart'))
            ->assertOk()
            ->assertSee('Your cart is empty');
    }

    public function test_product_seeding_does_not_overwrite_live_paddle_settings(): void
    {
        $product = Product::where('slug', 'practical-systems-playbook')->firstOrFail();
        $product->update([
            'is_coming_soon' => false,
            'paddle_price_id' => 'pri_live_ebook',
        ]);

        $this->seed(StoreProductSeeder::class);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_coming_soon' => false,
            'paddle_price_id' => 'pri_live_ebook',
        ]);
    }

    public function test_available_products_can_reach_one_time_paddle_checkout(): void
    {
        Config::set('cashier.client_side_token', 'test_token');
        Config::set('cashier.api_key', 'test_api_key');

        $user = User::factory()->create();
        $user->customer()->create([
            'paddle_id' => 'ctm_test_123',
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $product = Product::where('slug', 'practical-systems-playbook')->firstOrFail();
        $product->update([
            'is_coming_soon' => false,
            'paddle_price_id' => 'pri_test_ebook',
        ]);

        $this->actingAs($user)
            ->post(route('shop.cart.store', $product))
            ->assertRedirect(route('shop.cart'));

        $this->actingAs($user)
            ->post(route('shop.checkout'))
            ->assertOk()
            ->assertSee('Complete your purchase')
            ->assertSee('pri_test_ebook', false)
            ->assertSee('One-time purchase');

        $firstOrderId = Order::query()->sole()->id;

        $this->actingAs($user)
            ->post(route('shop.checkout'))
            ->assertOk()
            ->assertSee('Order #'.$firstOrderId);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => Order::STATUS_PENDING,
            'total' => 1900,
            'currency' => 'EUR',
        ]);
        $this->assertDatabaseCount('orders', 1);
        $this->assertSame($firstOrderId, Order::query()->sole()->id);

        $this->get(route('shop.cart'))
            ->assertSee('The Practical Systems Playbook')
            ->assertDontSee('Your cart is empty');

        $order = Order::query()->sole();

        $this->actingAs($user)
            ->get(route('shop.checkout.success', $order))
            ->assertOk()
            ->assertSee('checkPaymentStatus', false);

        $this->actingAs($user)
            ->getJson(route('shop.checkout.status', $order))
            ->assertOk()
            ->assertExactJson(['completed' => false]);

        $this->get(route('shop.cart'))->assertSee('Your cart is empty');
    }

    public function test_physical_product_requires_a_north_macedonian_address_and_enters_delivery_queue(): void
    {
        Config::set('cashier.client_side_token', 'test_token');
        Config::set('cashier.api_key', 'test_api_key');

        $user = User::factory()->create();
        $user->customer()->create([
            'paddle_id' => 'ctm_board_game_buyer',
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $product = Product::where('slug', 'startup-signals-board-game')->firstOrFail();
        $product->update([
            'is_coming_soon' => false,
            'paddle_price_id' => 'pri_test_board_game',
        ]);

        $this->actingAs($user)->post(route('shop.cart.store', $product));

        $this->actingAs($user)
            ->get(route('shop.cart'))
            ->assertOk()
            ->assertSee('Delivery address')
            ->assertSee('only within North Macedonia');

        $this->actingAs($user)
            ->post(route('shop.checkout'))
            ->assertSessionHasErrors([
                'shipping_name',
                'shipping_phone',
                'shipping_address_line_1',
                'shipping_city',
                'shipping_postal_code',
                'shipping_country',
            ]);

        $this->assertDatabaseCount('orders', 0);

        $this->actingAs($user)
            ->post(route('shop.checkout'), [
                'shipping_name' => 'Elena Petrova',
                'shipping_phone' => '+389 70 123 456',
                'shipping_address_line_1' => 'Partizanski Odredi 10',
                'shipping_address_line_2' => 'Apartment 4',
                'shipping_city' => 'Skopje',
                'shipping_postal_code' => '1000',
                'shipping_country' => 'MK',
            ])
            ->assertOk()
            ->assertSee('Complete your purchase')
            ->assertSee('Back to cart');

        $this->actingAs($user)
            ->get(route('shop.cart'))
            ->assertOk()
            ->assertSee('value="Elena Petrova"', false)
            ->assertSee('value="+389 70 123 456"', false)
            ->assertSee('value="Partizanski Odredi 10"', false)
            ->assertSee('value="Apartment 4"', false)
            ->assertSee('value="Skopje"', false)
            ->assertSee('value="1000"', false);

        $order = Order::query()->sole();

        $this->assertSame(Order::DELIVERY_AWAITING_PAYMENT, $order->delivery_status);
        $this->assertTrue($order->requires_shipping);
        $this->assertSame('Elena Petrova', $order->shipping_name);
        $this->assertSame('MK', $order->shipping_country);

        $this->actingAs($user)
            ->get(route('shop.checkout.success', $order))
            ->assertOk()
            ->assertSee('Payment confirmation in progress')
            ->assertSee('physical order is awaiting payment confirmation')
            ->assertSee('Partizanski Odredi 10')
            ->assertDontSee('Go to my downloads');

        $transaction = new Transaction([
            'paddle_id' => 'txn_board_game_123',
            'total' => '3900',
            'currency' => 'EUR',
        ]);

        app(CompleteStoreOrder::class)->handle(new TransactionCompleted(
            $user,
            $transaction,
            ['data' => ['custom_data' => ['order_id' => (string) $order->id]]],
        ));

        $this->assertSame(Order::DELIVERY_READY_TO_SHIP, $order->refresh()->delivery_status);

        $this->actingAs($user)
            ->get(route('shop.checkout.success', $order))
            ->assertOk()
            ->assertSee('Payment confirmed')
            ->assertSee('Your physical order is confirmed')
            ->assertSee('Ready to ship')
            ->assertSee('View order history')
            ->assertSee('Return to shop')
            ->assertDontSee('My downloads');

        $this->actingAs($user)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Delivery: Ready to ship')
            ->assertSee('Partizanski Odredi 10');
    }

    public function test_completed_paddle_transaction_unlocks_an_ebook_download(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $product = Product::where('slug', 'practical-systems-playbook')->firstOrFail();
        Storage::disk('local')->put($product->download_path, 'example ebook');

        $order = $user->orders()->create([
            'status' => Order::STATUS_PENDING,
            'total' => $product->price,
            'currency' => $product->currency,
        ]);
        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'paddle_price_id' => 'pri_test_ebook',
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $transaction = new Transaction([
            'paddle_id' => 'txn_test_123',
            'total' => '1900',
            'currency' => 'EUR',
        ]);

        app(CompleteStoreOrder::class)->handle(new TransactionCompleted(
            $user,
            $transaction,
            ['data' => ['custom_data' => ['order_id' => (string) $order->id]]],
        ));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => Order::STATUS_COMPLETED,
            'total' => 1900,
            'paddle_transaction_id' => 'txn_test_123',
        ]);

        $this->actingAs($user)
            ->get(route('shop.checkout.success', $order))
            ->assertOk()
            ->assertSee('Payment confirmed')
            ->assertSee('Your e-book is ready')
            ->assertSee('Download PDF')
            ->assertSee('My downloads')
            ->assertDontSee('Physical delivery');

        $this->actingAs($user)
            ->getJson(route('shop.checkout.status', $order))
            ->assertOk()
            ->assertExactJson(['completed' => true]);

        $this->actingAs(User::factory()->create())
            ->getJson(route('shop.checkout.status', $order))
            ->assertNotFound();

        $this->actingAs($user)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Order #'.$order->id)
            ->assertSee('Paid')
            ->assertSee($product->name)
            ->assertSee(route('downloads.show', $product));

        $this->actingAs($user)
            ->get(route('profile'))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee('method="POST" action="'.route('downloads.show', $product).'"', false);

        $this->actingAs($user)
            ->post(route('downloads.show', $product))
            ->assertDownload($product->slug.'.pdf');
    }

    public function test_completed_mixed_order_shows_both_delivery_flows(): void
    {
        $user = User::factory()->create();
        $boardGame = Product::where('slug', 'startup-signals-board-game')->firstOrFail();
        $ebook = Product::where('slug', 'practical-systems-playbook')->firstOrFail();

        $order = $user->orders()->create([
            'status' => Order::STATUS_COMPLETED,
            'total' => $boardGame->price + $ebook->price,
            'currency' => 'EUR',
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

        foreach ([$boardGame, $ebook] as $product) {
            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'paddle_price_id' => 'pri_'.$product->id,
                'quantity' => 1,
                'unit_price' => $product->price,
            ]);
        }

        $this->actingAs($user)
            ->get(route('shop.checkout.success', $order))
            ->assertOk()
            ->assertSee('Physical delivery')
            ->assertSee('Digital delivery')
            ->assertSee($boardGame->name)
            ->assertSee($ebook->name)
            ->assertSee('Download PDF');
    }

    public function test_users_cannot_download_ebooks_they_do_not_own(): void
    {
        Storage::fake('local');

        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $product = Product::where('slug', 'practical-systems-playbook')->firstOrFail();
        Storage::disk('local')->put($product->download_path, 'example ebook');

        $order = $owner->orders()->create([
            'status' => Order::STATUS_COMPLETED,
            'total' => $product->price,
            'currency' => $product->currency,
            'completed_at' => now(),
        ]);
        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'paddle_price_id' => 'pri_test_ebook',
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $this->actingAs($otherUser)
            ->post(route('downloads.show', $product))
            ->assertNotFound();

        $this->get(route('downloads.show', $product))->assertStatus(405);
    }

    public function test_an_unverified_owner_can_download_a_purchased_ebook_from_their_library(): void
    {
        Storage::fake('local');

        $user = User::factory()->unverified()->create();
        $product = Product::where('slug', 'practical-systems-playbook')->firstOrFail();
        Storage::disk('local')->put($product->download_path, 'example ebook');

        $order = $user->orders()->create([
            'status' => Order::STATUS_COMPLETED,
            'total' => $product->price,
            'currency' => $product->currency,
            'completed_at' => now(),
        ]);
        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'paddle_price_id' => 'pri_test_ebook',
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $this->actingAs($user)
            ->post(route('downloads.show', $product))
            ->assertDownload($product->slug.'.pdf');
    }
}
