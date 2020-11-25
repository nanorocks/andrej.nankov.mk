<?php

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string(Project::TITLE);
            $table->text(Project::DESCRIPTION);
            $table->date(Project::DATE);
            $table->string(Project::STATUS);
            $table->string(Project::LINK);
            $table->string(Project::IMAGE);
            $table->unsignedBigInteger(Project::USER_ID);
            $table->foreign(Project::USER_ID)->references(User::ID)->on(User::TABLE);
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
        Schema::dropIfExists('projects');
    }
}
