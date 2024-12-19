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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the category
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->text('description')->nullable(); // Optional description of the category
            $table->unsignedBigInteger('parent_id')->nullable(); // For nested categories (hierarchy)
            $table->integer('story_count')->default(0); // Number of stories in this category
            $table->timestamps();
        
            // Foreign key for self-referencing parent category
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
