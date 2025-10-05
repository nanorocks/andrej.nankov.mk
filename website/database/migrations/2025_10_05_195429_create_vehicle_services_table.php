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
        Schema::create('vehicle_services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            // Service details
            $table->string('service_type')->nullable();     // e.g. oil_change, tires, inspection
            $table->string('title')->nullable();            // human-friendly title
            $table->text('description')->nullable();

            // Due criteria (date and/or mileage)
            $table->date('due_date')->nullable();
            $table->unsignedInteger('due_mileage')->nullable();

            // Recurrence (optional)
            $table->unsignedSmallInteger('interval_months')->nullable();
            $table->unsignedInteger('interval_mileage')->nullable();

            // Status & scheduling
            $table->enum('priority', ['low', 'normal', 'high', 'critical'])->default('normal');
            $table->enum('status', ['upcoming', 'scheduled', 'completed', 'cancelled', 'overdue'])->default('upcoming');
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            // Vendor / cost (optional)
            $table->string('vendor_name')->nullable();
            $table->string('vendor_contact')->nullable();
            $table->decimal('estimated_cost', 12, 2)->nullable();

            // Reminders
            $table->smallInteger('reminder_offset_days')->nullable(); // e.g. -7 => 7 days before
            $table->dateTime('reminder_at')->nullable();

            // Extra
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Helpful indexes
            $table->index(['vehicle_id', 'status']);
            $table->index(['due_date']);
            $table->index(['due_mileage']);
            $table->index(['priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_upcoming_services');
    }
};
