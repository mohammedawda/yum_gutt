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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->string('national_id_photo')->nullable();
            $table->tinyInteger('national_id_photo_type')->nullable()->comment('1 => passport, 2 => national_id');
            $table->string('national_id')->nullable();
            $table->boolean('is_open')->default(0)->comment('this value override store schedule');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->index(['user_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
