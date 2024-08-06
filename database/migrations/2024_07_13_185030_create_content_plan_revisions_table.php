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
        Schema::create('content_plan_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_plan_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('revision_no')->nullable();
            $table->string('detail')->nullable();
            $table->string('title')->nullable();
            $table->string('asset')->nullable();
            $table->string('caption')->nullable();
            $table->enum('status', ['responded', 'uploaded', 'revision', 'done'])->default('responded')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_plan_revisions');
    }
};
