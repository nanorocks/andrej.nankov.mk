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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique(); // Unique identifier for the service
            $table->string('title'); // Title of the service
            $table->text('description'); // Description of the service
            $table->decimal('price', 10, 2); // Price of the service (using decimal for accurate money representation)
            $table->string('photo_url')->nullable();
            $table->string('icon')->nullable(); // URL of the service's image
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->timestamps(); // Created and updated timestamps
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
