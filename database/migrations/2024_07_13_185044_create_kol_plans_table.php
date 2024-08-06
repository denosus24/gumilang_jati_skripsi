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
        Schema::create('kol_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_report_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('influencer_name')->nullable();
            $table->string('influencer_url')->nullable();
            $table->string('total_followers')->nullable();
            $table->text('caption')->nullable();
            $table->string('post_url')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('views')->nullable();
            $table->integer('likes')->nullable();
            $table->integer('comments')->nullable();
            $table->integer('shares')->nullable();
            $table->integer('direct_purchases')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kol_plans');
    }
};
