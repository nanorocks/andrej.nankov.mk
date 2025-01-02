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
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('slug')->unique();
            $table->json('keywords');
            $table->string('title');
            $table->text('description');
            $table->string('meta_robots')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->json('structured_data')->nullable();
            $table->string('locale')->nullable();
            $table->float('sitemap_priority')->nullable();
            $table->string('sitemap_frequency')->nullable();
            $table->timestamp('last_seo_audit')->nullable();
            $table->text('custom_scripts')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
