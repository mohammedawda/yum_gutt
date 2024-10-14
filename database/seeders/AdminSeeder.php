<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'         => 'Super admin',
            'email'        => 'super@email.com',
            'phone'        => '01012345678',
            'password'     => Hash::make('123456789'),
            'password_str' => '123456789',
            'status'       => 1,
            'country_id'   => 1,
            'city_id'      => 1,
            'role_id'      => 1,
        ]);
    }
}
