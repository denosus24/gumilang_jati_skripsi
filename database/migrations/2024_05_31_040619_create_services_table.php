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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('code');
            $table->string('name');
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->longText('people_in_needs')->nullable();
            $table->longText('advantages')->nullable();
            $table->longText('images')->nullable();
            $table->longText('workflow_image')->nullable();
            $table->longText('faqs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
