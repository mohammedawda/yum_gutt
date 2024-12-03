<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         DB::table('users')->insert([
            [
                'name'              => 'store',
                'email'             => 'store@email.com',
                'phone'             => '01012345678',
                'password'          => Hash::make('123456789'),
                'password_str'      => '123456789',
                'status'            => 1,
                'country_id'        => 1,
                'country_code'      => '+20',
                'full_phone'        => '+2001012345678',
                'city_id'           => 1,
                'role_id'           => 2,
                'email_verified_at' => now(),
            ],[
                'name'              => 'user',
                'email'             => 'user@email.com',
                'phone'             => '01012345679',
                'password'          => Hash::make('123456789'),
                'password_str'      => '123456789',
                'status'            => 1,
                'country_id'        => 1,
                'country_code'      => '+20',
                'full_phone'        => '+2001012345679',
                'city_id'           => 1,
                'role_id'           => 3,
                'email_verified_at' => now(),
            ],
        ]);
        DB::table('stores')->insert([
            [
                'user_id'                => 2,
                'national_id_photo'      => null,
                'national_id_photo_type' => null,
                'national_id'            => null,
                'is_open'                => 1,
                'serial_number'           => 3,
                'category_id'=>1
            ],
        ]);
    }
}
