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
        Schema::create('extra_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('extra_product_category_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('price');
            $table->string('image');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['extra_product_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_products');
    }
};
