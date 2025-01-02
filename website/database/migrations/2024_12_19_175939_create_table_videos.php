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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique(); // Unique identifier for the video
            $table->string('title'); // Title of the video
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->text('description')->nullable(); // Description of the video
            $table->string('video_url'); // URL to the video file or embed link
            $table->string('thumbnail_url')->nullable(); // URL to the video thumbnail
            $table->unsignedBigInteger('author_id'); // Foreign key for the uploader or author
            $table->json('tags')->nullable(); // Tags for the video (e.g., ["tutorial", "coding"])
            $table->integer('views_count')->default(0); // Number of views
            $table->integer('likes_count')->default(0); // Number of likes
            $table->integer('comments_count')->default(0); // Number of comments
            $table->boolean('is_published')->default(false); // Video visibility
            $table->timestamp('published_at')->nullable(); // Publish date
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['slug', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
