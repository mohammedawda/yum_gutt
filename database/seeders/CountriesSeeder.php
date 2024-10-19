<?php

namespace Database\Seeders;

use getways\countries\models\Country;
use Illuminate\Database\Seeder;
class CountriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Country::create([
            'name'          => ['en' => 'default country', 'ar' => 'بلد افتراضى'],
            'code'          => 'dc',
            'currency_code' => 'dc',
            'status'        => 1,
        ]);
    }
}
