<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CountriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $countries = [
            [
                'name'          => '',
                'code'          => 'eg',
                'Currency_code' => 'egp',
                'status'        => 1,
            ],[
                'name'          => 'sweden' ,
                'code'          => 'se',
                'Currency_code' => 'se',
                'status'        => 1,
            ],[
                'name'          => 'United Arab Emirates' ,
                'code'          => 'AE',
                'Currency_code' => 'UAE',
                'status'        => 0,
            ]
        ];

        DB::table('countries')->insert($countries);
    }
}
