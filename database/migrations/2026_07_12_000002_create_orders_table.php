<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parcel_id')->constrained()->cascadeOnDelete();
            $table->string('buyer_name');
            $table->string('buyer_email');
            $table->string('buyer_phone');
            $table->decimal('amount', 14, 2);
            $table->string('currency', 3)->default('GHS');
            $table->string('status')->default('pending');
            $table->string('paystack_reference')->unique();
            $table->string('paystack_access_code')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('payment_payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
