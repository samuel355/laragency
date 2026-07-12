<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_listings', function (Blueprint $table): void {
            $table->index('is_published');
            $table->index('property_type');
            $table->index('type');
            $table->index('city');
            $table->index('status');
            $table->index('is_featured');
            $table->index('is_investment');
            $table->index('is_new');
            $table->index('community_id');
            $table->index('team_member_id');
        });

        Schema::table('parcels', function (Blueprint $table): void {
            $table->index('status');
        });

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->index('is_published');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::table('property_listings', function (Blueprint $table): void {
            $table->dropIndex(['is_published']);
            $table->dropIndex(['property_type']);
            $table->dropIndex(['type']);
            $table->dropIndex(['city']);
            $table->dropIndex(['status']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['is_investment']);
            $table->dropIndex(['is_new']);
            $table->dropIndex(['community_id']);
            $table->dropIndex(['team_member_id']);
        });

        Schema::table('parcels', function (Blueprint $table): void {
            $table->dropIndex(['status']);
        });

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->dropIndex(['is_published']);
            $table->dropIndex(['category']);
        });
    }
};
