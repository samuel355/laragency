<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_listings', function (Blueprint $table): void {
            $table->index(['is_published', 'created_at']);
            $table->index(['is_published', 'is_featured', 'created_at']);
            $table->index(['is_published', 'price']);
        });

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->index(['is_published', 'published_at']);
            $table->index(['is_published', 'category', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::table('property_listings', function (Blueprint $table): void {
            $table->dropIndex(['is_published', 'created_at']);
            $table->dropIndex(['is_published', 'is_featured', 'created_at']);
            $table->dropIndex(['is_published', 'price']);
        });

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->dropIndex(['is_published', 'published_at']);
            $table->dropIndex(['is_published', 'category', 'published_at']);
        });
    }
};
