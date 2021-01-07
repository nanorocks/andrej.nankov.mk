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
            Post::TITLE => 'Welcome post',
            Post::UNIQUE_ID => GenerateUniqueId::uuid(),
            Post::SUB_TITLE => 'Just another regular template for welcome post.',
            Post::TEXT => "This is my welcome post new content coming up in short time.",
            Post::DATE => "2020.01.03",
            Post::STATUS => true,
            Post::REFERENCES => 'link1;link2',
            Post::IMAGE => 'https://secure.gravatar.com/avatar/78fcb9f09832d6d4053d415433f2ee43?s=150',
            Post::META_BUDGES => 'docker;php',
            Post::CATEGORY => 'web development',
            Post::USER_ID => User::all()->random()->id
        ]);

        DB::table(Post::TABLE)->insert([
            Post::TITLE => 'Post title 2',
            Post::UNIQUE_ID => GenerateUniqueId::uuid(),
            Post::SUB_TITLE => 'Post sub title 2',
            Post::TEXT => "This is my post text 2",
            Post::DATE => "2020.01.03",
            Post::STATUS => false,
            Post::REFERENCES => 'link1;link2',
            Post::META_BUDGES => 'rpm;py',
            Post::CATEGORY => 'category2',
            Post::USER_ID => User::all()->random()->id
        ]);
    }
}
