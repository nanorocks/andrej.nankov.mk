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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // User's full name
            $table->string('avatar')->nullable(); // URL to the user's avatar image
            $table->string('email')->unique(); // User's email address
            $table->timestamp('email_verified_at')->nullable(); // Verification date for the email
            $table->string('password'); // Hashed password
            $table->rememberToken(); // Token for "remember me" functionality
            $table->string('phone_number')->nullable(); // User's phone number
            $table->string('address')->nullable(); // User's physical address
            $table->string('website_url')->nullable(); // User's personal website or blog URL
            $table->string('medium_url')->nullable(); // User's Medium profile URL
            $table->json('social_media')->nullable(); // JSON to store multiple social media links
            $table->string('role')->default('user'); // User role (e.g., "admin", "editor", "user")
            $table->text('bio')->nullable(); // Short biography or description of the user
            $table->timestamps(); // Created and updated timestamps
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
