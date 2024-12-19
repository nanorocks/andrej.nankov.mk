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
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // Unique identifier for the project
            $table->string('uuid')->unique(); // Unique identifier using UUID
            $table->string('slug')->unique();
            $table->string('title'); // Title of the project
            $table->text('description'); // Description of the project
            $table->date('start_date'); // Start date of the project
            $table->date('end_date')->nullable(); // End date of the project (if ongoing or not yet completed)
            $table->string('project_url')->nullable(); // URL link to the project (if applicable)
            $table->string('image_url')->nullable(); // URL of an image representing the project
            $table->enum('status', ['ongoing', 'completed', 'archived'])->default('ongoing'); // Status of the project
            $table->unsignedBigInteger('user_id'); // Foreign key linking the project to a specific user (the owner)
            $table->timestamps(); // Created and updated timestamps
        
            // Foreign key constraint for linking the project to a user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
