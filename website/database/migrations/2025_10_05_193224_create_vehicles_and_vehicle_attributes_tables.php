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
        // vehicles
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // use string for owner in case we want to allow non-drivers to own vehicles
            $table->string('owner')->nullable();

            // Core identifiers (optional if you keep everything in attributes)
            $table->string('vin', 32)->unique()->nullable();
            $table->string('registration_number', 32)->unique()->nullable();
            $table->string('photo')->nullable(); // include photo of vehicle file path
            // Status / notes
            $table->enum('status', ['available', 'rented', 'maintenance', 'sold', 'inactive'])->default('available');
            $table->date('purchased_at')->nullable();
            $table->text('notes')->nullable();

            $table->index(['status']);

            $table->softDeletes();
            $table->timestamps();
        });

        // Attribute → Value pairs (EAV)
        Schema::create('vehicle_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            $table->string('attribute');       // e.g. color, engine, seats
            $table->text('value')->nullable(); // e.g. red, 2.0 TDI, 5
            $table->string('value_type')->default('string'); // string, int, bool, json
            $table->json('meta')->nullable();  // optional extra metadata

            $table->timestamps();

            $table->unique(['vehicle_id', 'attribute']);
            $table->index('attribute');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_attributes');
        Schema::dropIfExists('vehicles');
    }
};
