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
            ->assertSee('Visit Andrej Nankov on Medium');
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

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => Order::STATUS_PENDING,
            'total' => 1900,
            'currency' => 'EUR',
        ]);

        $this->get(route('shop.cart'))->assertSee('Your cart is empty');
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
            ->get(route('profile'))
            ->assertOk()
            ->assertSee('Order #'.$order->id)
            ->assertSee('Completed')
            ->assertSee($product->name)
            ->assertSee(route('downloads.show', $product));

        $this->actingAs($user)
            ->get(route('downloads.show', $product))
            ->assertDownload($product->slug.'.pdf');
    }

    public function test_users_cannot_download_ebooks_they_do_not_own(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $product = Product::where('slug', 'practical-systems-playbook')->firstOrFail();
        Storage::disk('local')->put($product->download_path, 'example ebook');

        $this->actingAs($user)
            ->get(route('downloads.show', $product))
            ->assertNotFound();
    }
}
