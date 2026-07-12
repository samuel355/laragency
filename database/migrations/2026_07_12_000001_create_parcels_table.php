<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcels', function (Blueprint $table): void {
            $table->id();
            $table->string('plot_number')->unique();
            $table->string('title');
            $table->string('location_name');
            $table->decimal('price', 14, 2);
            $table->string('currency', 3)->default('GHS');
            $table->decimal('area_sqm', 12, 2);
            $table->string('status')->default('available');
            $table->json('geometry');
            $table->json('attributes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
