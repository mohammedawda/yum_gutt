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
        if(!Schema::hasColumn('stores', 'serial_number')) {
            Schema::table('stores', function (Blueprint $table) {
                $table->bigInteger('serial_number')->after('id')->unique();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('stores', 'serial_number')) {
            Schema::table('stores', function (Blueprint $table) {
                $table->dropColumn('serial_number');
            });
        }
    }
};
