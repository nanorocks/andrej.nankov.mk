<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(Config::TABLE)->insert([
            Config::PAGE_TITLE => 'Welcome',
            Config::PAGE_DESCRIPTION => 'Software engineer based in Skopje, Macedonia',
        ]);

        DB::table(Config::TABLE)->insert([
            Config::PAGE_TITLE => 'Projects',
            Config::PAGE_DESCRIPTION => 'Introduction on several latest projects',
        ]);

        DB::table(Config::TABLE)->insert([
            Config::PAGE_TITLE => 'Latest Posts',
            Config::PAGE_DESCRIPTION => 'Here you can read and explore blog posts',
        ]);

        DB::table(Config::TABLE)->insert([
            Config::PAGE_TITLE => 'Summary',
            Config::PAGE_DESCRIPTION => 'Summary for Andrej Nankov',
        ]);

        DB::table(Config::TABLE)->insert([
            Config::PAGE_TITLE => 'Highlights',
            Config::PAGE_DESCRIPTION => 'Professional Highlights',
        ]);
    }
}
