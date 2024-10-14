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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('city_id')->constrained('cities')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('action_by')->nullable()->constrained('users')->nullOnDelete()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('country_code')->nullable();
            $table->string('full_phone')->nullable();
            $table->integer('role_id');
            $table->string('otp')->nullable();
            $table->timestamp('latest_sent_otp')->nullable();
            $table->string('national_id_photo')->nullable();
            $table->string('national_id_photo_type')->nullable();
            $table->string('national_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_str');
            $table->string('fcm')->nullable();
            $table->boolean('status')->default(0)->comment('1 => active');
            $table->boolean('block')->default(0)->comment('1 => blocked');
            $table->longText('block_reason')->nullable();
            $table->timestamp('action_at')->nullable();
            $table->boolean('terms_and_condition')->default(0)->comment('1 => for accept terms');
            $table->bigInteger('wallet')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
