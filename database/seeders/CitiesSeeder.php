<?php

namespace Database\Seeders;

use getways\cities\models\City;
use Illuminate\Database\Seeder;
class CitiesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        City::create([
                'name' => ['en' => 'default city', 'ar' => 'مدينة افتراضية'],
            ]);
    }
}
