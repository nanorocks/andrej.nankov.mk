<?php

namespace Database\Seeders;

use App\Helpers\GenerateUniqueId;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(Post::TABLE)->insert([
            Post::TITLE => 'Post title 1',
            Post::UNIQUE_ID => GenerateUniqueId::uuid(),
            Post::SUB_TITLE => 'Post sub title 1',
            Post::TEXT => "This is my post text 1",
            Post::DATE => "2020.01.03",
            Post::STATUS => true,
            Post::REFERENCES => '{"1":"link1", "2":"link2"}',
            Post::IMAGE => 'no-img',
            Post::META_BUDGES => '{"budge-docker":"docker", "budge-php":"php"}',
            Post::CATEGORY => 'category1',
            Post::USER_ID => User::all()->random()->id
        ]);

        DB::table(Post::TABLE)->insert([
            Post::TITLE => 'Post title 2',
            Post::UNIQUE_ID => GenerateUniqueId::uuid(),
            Post::SUB_TITLE => 'Post sub title 2',
            Post::TEXT => "This is my post text 2",
            Post::DATE => "2020.01.03",
            Post::STATUS => false,
            Post::REFERENCES => '{"1":"link1", "2":"link2"}',
            Post::IMAGE => 'no-img',
            Post::META_BUDGES => '{"budge-rpm":"rpm", "budge-py":"py"}',
            Post::CATEGORY => 'category2',
            Post::USER_ID => User::all()->random()->id
        ]);
    }
}
