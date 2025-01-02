<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique(); // Unique identifier for the tool
            $table->string('title'); // Title of the tool
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->text('description')->nullable(); // Description of the tool
            $table->string('photo_url'); // URL of the tool's photo
            $table->string('caption')->nullable(); // Caption for the tool
            $table->string('website_url')->nullable(); // Official website URL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
