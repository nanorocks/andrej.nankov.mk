<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersBootstrapSeeder::class);
        $this->call(PostsBootstrapSeeder::class);
        $this->call(ProjectsBootstrapSeeder::class);
        $this->call(ConfigsBootstrapSeeder::class);
    }
}
