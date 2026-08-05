<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class StoreProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::firstOrCreate(
            ['slug' => 'startup-signals-board-game'],
            [
                'name' => 'Startup Signals',
                'type' => Product::TYPE_BOARD_GAME,
                'description' => 'A strategy board game about building products, reading the market, and making difficult founder decisions.',
                'price' => 3900,
                'currency' => 'EUR',
                'paddle_price_id' => null,
                'download_path' => null,
                'is_active' => true,
                'is_coming_soon' => true,
                'sort_order' => 10,
            ],
        );

        Product::firstOrCreate(
            ['slug' => 'practical-systems-playbook'],
            [
                'name' => 'The Practical Systems Playbook',
                'type' => Product::TYPE_EBOOK,
                'description' => 'A concise field guide for turning early software ideas into maintainable systems without unnecessary complexity.',
                'price' => 1900,
                'currency' => 'EUR',
                'paddle_price_id' => null,
                'download_path' => 'shop/practical-systems-playbook.pdf',
                'is_active' => true,
                'is_coming_soon' => true,
                'sort_order' => 20,
            ],
        );
    }
}
