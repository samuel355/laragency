<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communities', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('city');
            $table->string('region');
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table): void {
            $table->id();
            $table->string('client_name');
            $table->string('client_role')->nullable();
            $table->string('avatar_path')->nullable();
            $table->text('quote');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('partner_banks', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('logo_path');
            $table->string('url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('company_stats', function (Blueprint $table): void {
            $table->id();
            $table->string('label');
            $table->string('value');
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Market Trends');
            $table->string('excerpt');
            $table->longText('body');
            $table->string('cover_path')->nullable();
            $table->foreignId('team_member_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::table('property_listings', function (Blueprint $table): void {
            $table->string('property_type')->default('house')->after('type');
            $table->string('property_code')->nullable()->unique()->after('slug');
            $table->boolean('is_investment')->default(false)->after('is_featured');
            $table->boolean('is_new')->default(false)->after('is_investment');
            $table->timestamp('sold_at')->nullable()->after('is_published');
            $table->foreignId('community_id')->nullable()->after('region')->constrained()->nullOnDelete();
            $table->foreignId('team_member_id')->nullable()->after('community_id')->constrained()->nullOnDelete();
            $table->unsignedSmallInteger('garages')->default(0)->after('bathrooms');
            $table->unsignedSmallInteger('floors')->default(1)->after('garages');
            $table->unsignedSmallInteger('year_built')->nullable()->after('floors');
            $table->string('video_url')->nullable()->after('image_paths');
            $table->string('virtual_tour_url')->nullable()->after('video_url');
            $table->json('floor_plan_paths')->nullable()->after('virtual_tour_url');
            $table->json('nearby_places')->nullable()->after('floor_plan_paths');
            $table->string('title_status')->nullable()->after('nearby_places');
        });
    }

    public function down(): void
    {
        Schema::table('property_listings', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('team_member_id');
            $table->dropConstrainedForeignId('community_id');
            $table->dropColumn([
                'property_type', 'property_code', 'is_investment', 'is_new', 'sold_at',
                'garages', 'floors', 'year_built', 'video_url', 'virtual_tour_url',
                'floor_plan_paths', 'nearby_places', 'title_status',
            ]);
        });

        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('company_stats');
        Schema::dropIfExists('partner_banks');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('communities');
    }
};
