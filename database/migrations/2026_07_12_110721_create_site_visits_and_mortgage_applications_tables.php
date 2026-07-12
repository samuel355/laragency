<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visits', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('property_listing_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parcel_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('team_member_id')->nullable()->constrained()->nullOnDelete();
            $table->date('preferred_date');
            $table->string('preferred_time')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('requested');
            $table->timestamps();
        });

        Schema::create('mortgage_applications', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('property_listing_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('partner_bank_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('property_price', 14, 2)->nullable();
            $table->decimal('down_payment', 14, 2)->nullable();
            $table->decimal('monthly_income', 14, 2)->nullable();
            $table->unsignedTinyInteger('loan_term_years')->default(15);
            $table->string('employment_status')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mortgage_applications');
        Schema::dropIfExists('site_visits');
    }
};
