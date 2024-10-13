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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('country_id')->constrained('countries')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('city_id')->constrained('cities')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('lat');
            $table->string('lng');
            $table->string('name');
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
        Schema::dropIfExists('user_addresses');
    }
};
