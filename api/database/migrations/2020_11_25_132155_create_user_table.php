<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string(User::EMAIL);
            $table->string(User::NAME);
            $table->text(User::INTRO);
            $table->text(User::SUMMARY);
            $table->string(User::CURRENT_WORK);
            $table->mediumText(User::TOP_PROGRAMMING_LANGUAGES)->nullable();
            $table->mediumText(User::GOALS);
            $table->json(User::QUOTES);
            $table->json(User::SOC_MEDIA);
            $table->string(User::PASSWORD);
            $table->longText(User::HIGHLIGHTS);
            $table->string(User::ADDRESS);
            $table->string(User::PHONE);
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
        Schema::dropIfExists('users');
    }
}
