<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('about_pages');
        Schema::dropIfExists('newsletter_pages');

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('flag'); // Page identifier: e.g. 'about', 'newsletter'
            $table->string('profile_image')->nullable();
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('role')->nullable();
            $table->string('headline')->nullable();
            $table->text('intro')->nullable();
            $table->text('content')->nullable();
            $table->string('cv_url')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('include_seo_in_header')->default(true);

            // SEO fields
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_author')->nullable();
            $table->string('seo_robots')->nullable();

            // Open Graph
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_type')->nullable();
            $table->string('og_url')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_image_alt')->nullable();
            $table->string('og_site_name')->nullable();

            // Twitter
            $table->string('twitter_card')->nullable();
            $table->string('twitter_title')->nullable();
            $table->string('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('twitter_image_alt')->nullable();
            $table->string('twitter_creator')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
