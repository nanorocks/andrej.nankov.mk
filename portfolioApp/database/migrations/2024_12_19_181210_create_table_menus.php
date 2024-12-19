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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Title of the menu item
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->string('url')->nullable(); // URL the menu item links to (if applicable)
            $table->unsignedBigInteger('parent_id')->nullable(); // Foreign key for parent menu item (to create a hierarchy)
            $table->integer('order')->default(0); // Order of the menu item for display
            $table->timestamps();
        
            // Foreign key constraint for self-referencing parent menu
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
