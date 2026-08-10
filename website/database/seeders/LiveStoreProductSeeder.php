<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use RuntimeException;

/**
 * Enables the production catalog item against the live Paddle catalog.
 *
 * Run this seeder only in production. Staging must continue using its own
 * sandbox price IDs and must never receive a live Paddle price ID.
 */
class LiveStoreProductSeeder extends Seeder
{
    public function run(): void
    {
        $priceId = (string) env('PADDLE_LIVE_EBOOK_PRICE_ID');

        if ($priceId === '' || ! str_starts_with($priceId, 'pri_')) {
            throw new RuntimeException(
                'PADDLE_LIVE_EBOOK_PRICE_ID must contain the active live Paddle price ID.',
            );
        }

        $product = Product::query()
            ->where('slug', 'practical-systems-playbook')
            ->firstOrFail();

        $product->forceFill([
            'paddle_price_id' => $priceId,
            'is_active' => true,
            'is_coming_soon' => false,
        ])->save();
    }
}
