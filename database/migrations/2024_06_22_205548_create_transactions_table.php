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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'paid', 'expired', 'declined'])->default('pending');
            $table->string('invoice_number')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('user_name')->nullable();
            $table->decimal('base_amount')->nullable();
            $table->decimal('discount_amount')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('duitku_reference')->nullable();
            $table->string('payment_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
