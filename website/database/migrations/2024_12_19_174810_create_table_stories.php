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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('slug')->unique();
            $table->string('title'); // Title of the story
            $table->text('content'); // Main content of the story
            $table->text('excerpt')->nullable(); // Short summary or introduction
            $table->unsignedBigInteger('author_id'); // Foreign key for the author
            $table->json('tags')->nullable(); // Tags for the story (e.g., ["tech", "finance"])
            $table->unsignedBigInteger('category_id')->nullable(); // Foreign key for categories
            $table->timestamp('published_at')->nullable(); // Publishing date and time
            $table->boolean('is_published')->default(false); // Story visibility (published or draft)
            $table->boolean('is_draft')->default(true); // Whether the story is in draft status
            $table->integer('views_count')->default(0); // Number of views
            $table->integer('likes_count')->default(0); // Number of likes
            $table->integer('comments_count')->default(0); // Number of comments
            $table->string('featured_image')->nullable(); // URL or path to the featured image
            $table->json('media')->nullable(); // Additional media attachments

            // Foreign key to relate with seo_pages
            $table->unsignedBigInteger('seo_page_id')->nullable(); // SEO attributes reference

            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('seo_page_id')->references('id')->on('seo_pages')->onDelete('cascade');

            // Indexes
            $table->index(['slug', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
