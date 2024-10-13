<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use getways\users\models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Test admin',
            'email' => 'test@example.com',
            'phone' => '01012345678',
            'password' => Hash::make('123456789'),
            'password_str' => '123',
            'status' => '1',
            'country_id' => '1',
            'city_id' => '138',
        ]);
    }
}
