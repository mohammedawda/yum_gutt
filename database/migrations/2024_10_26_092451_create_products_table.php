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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('product_categories')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('store_id')->constrained('stores')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->longText('description')->nullable();
            $table->float('main_price');
            $table->float('discount')->nullable();
            $table->string('image')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->index(['store_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
