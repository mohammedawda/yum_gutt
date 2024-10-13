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
        Schema::create('online_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('order_id');
            $table->string('tran_ref')->nullable();
            $table->string('type')->comment('wallet,purchase,sale,...');
            $table->string('amount');
            $table->string('description');
            $table->string('payment_url')->nullable();
            $table->string('callback_url')->nullable();
            $table->boolean('status')->default('0')->comment('1 for pay successfully');
            $table->longText('response_from_payment')->nullable();
            $table->longText('callback_payment_response')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_payments');
    }
};
