<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use getways\users\models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::create([
             'first_name' => 'Test user',
             'email' => 'test1@example.com',
             'phone' => '01012345678',
             'password' => Hash::make('123456789'),
             'password_str' => '123456789',
             'status' => '1',
             'country_id' => '1',
             'country_code' => '+20',
             'full_phone'=>'+2001012345678',
             'city_id' => '138',
             'email_verified_at'=>now()
         ]);
    }
}
