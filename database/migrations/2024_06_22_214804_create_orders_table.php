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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->enum('status', ['pending', 'ongoing', 'revision', 'done'])->default('pending')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('transaction_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->string('user_name')->nullable();
            $table->string('package_name')->nullable();
            $table->integer('quantity')->default(1)->nullable();
            $table->decimal('base_amount')->nullable();
            $table->decimal('discount_amount')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('briefs')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
