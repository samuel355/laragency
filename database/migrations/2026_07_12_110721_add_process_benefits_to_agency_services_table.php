<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agency_services', function (Blueprint $table): void {
            $table->json('process')->nullable()->after('body');
            $table->json('benefits')->nullable()->after('process');
        });
    }

    public function down(): void
    {
        Schema::table('agency_services', function (Blueprint $table): void {
            $table->dropColumn(['process', 'benefits']);
        });
    }
};
