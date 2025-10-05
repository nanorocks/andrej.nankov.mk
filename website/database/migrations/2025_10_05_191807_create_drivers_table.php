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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            // Every driver is a user
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->unique();

            // Driver-specific fields
            $table->string('license_number')->unique();
            $table->string('license_category')->nullable();     // e.g. B, C, D
            $table->date('license_issued_at')->nullable();
            $table->date('license_expires_at')->nullable();

            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('date_of_birth')->nullable();

            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');

            $table->json('attributes')->nullable(); // additional key/value data
            $table->timestamps();

            // Helpful indexes
            $table->index(['status']);
            $table->index(['license_expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
