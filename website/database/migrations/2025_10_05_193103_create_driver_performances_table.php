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
        Schema::create('driver_performances', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('driver_id')
                ->constrained('drivers')
                ->cascadeOnDelete();

            // Periodization
            $table->enum('period_type', ['daily', 'weekly', 'monthly', 'quarterly', 'yearly', 'lifetime'])->default('daily');
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();

            // KPIs
            $table->unsignedInteger('trips_completed')->default(0);
            $table->unsignedInteger('distance_km')->default(0);
            $table->decimal('driving_hours', 7, 2)->default(0);   // e.g. 1234.50 hours
            $table->decimal('on_time_rate', 5, 2)->nullable();     // 0–100 (%)
            $table->decimal('rating', 3, 2)->nullable();           // 0–5
            $table->unsignedSmallInteger('accidents_count')->default(0);
            $table->unsignedSmallInteger('incidents_count')->default(0);
            $table->unsignedSmallInteger('infractions_count')->default(0);
            $table->decimal('fuel_used_liters', 10, 2)->nullable();
            $table->decimal('fuel_efficiency_km_per_l', 8, 2)->nullable();
            $table->decimal('avg_speed_kmh', 6, 2)->nullable();

            // Overall score and extra
            $table->unsignedSmallInteger('score')->nullable();     // 0–100
            $table->json('metrics')->nullable();                   // arbitrary extra metrics
            $table->timestamp('last_evaluated_at')->nullable();

            $table->timestamps();

            // Constraints / indexes
            $table->unique(['driver_id', 'period_type', 'period_start']);
            $table->index(['driver_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_performances');
    }
};
