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
            $table->foreignId('country_id')->constrained('countries')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('store_id')->constrained('stores')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('user_id')->constrained('users')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('order_code')->unique();
            $table->double('total_price')->nullable();
            $table->double('cart_price')->nullable();
            $table->double('discount')->default(0);
            $table->float('delivery_cost')->default(0);
            $table->tinyInteger('delivery_status')->default(1)->comment('1 => pending, 2 => prepared, 3 => in_progress, 4 => deliverd');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->index(['country_id', 'store_id', 'user_id']);
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
