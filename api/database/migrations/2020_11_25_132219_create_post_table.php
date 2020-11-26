<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string(Post::TITLE);
            $table->string(Post::SUB_TITLE);
            $table->text(Post::TEXT);
            $table->date(Post::DATE);
            $table->boolean(Post::STATUS);
            $table->json(Post::REFERENCES);
            $table->string(Post::IMAGE);
            $table->json(Post::META_BUDGES);
            $table->string(Post::CATEGORY);
            $table->unsignedBigInteger(Post::USER_ID);
            $table->foreign(Post::USER_ID)->references(User::ID)->on(User::TABLE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
