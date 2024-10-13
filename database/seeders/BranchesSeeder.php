<?php

namespace Database\Seeders;

use Carbon\Carbon;
use getways\users\models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [ 'country_id' => 1, 'city_id' => 1, 'name_ar' => 'The 5th Settlement branch', 'name_en' => 'The 5th Settlement branch', 'phone' => '937-449-5593', 'address' => '208 Cairo Business Plaza - New Cairo', 'working_time' => 'From 11 am to 7 pm (Saturday to Thursday) Friday from 2:00 pm to 8 pm', 'lat' => '-39.5972', 'lng' => '-100.4256', 'status' => 1],
            [ 'country_id' => 1, 'city_id' => 1, 'name_ar' => 'Al Sagha branch', 'name_en' => 'Al Sagha branch', 'phone' => '474-239-9335', 'address' => '1 Peacock Alley, off Al Moez Street - Al Gamaleya', 'working_time' => 'From 11 am to 8 pm (Sunday off) Friday from 11:00 pm to 8 pm', 'lat' => '16.0667', 'lng' => '-160.9162', 'status' => 1],
            [ 'country_id' => 1, 'city_id' => 1, 'name_ar' => 'El Sheikh Zayed branch', 'name_en' => 'El Sheikh Zayed branch', 'phone' => '274-378-8986', 'address' => 'Waslet Dahshur Rd - El Sheikh Zayed - Giza', 'working_time' => 'From 11 am to 10 pm (Sunday off) Friday from 2:00 pm to 10 pm', 'lat' => '-70.4685', 'lng' => '-78.2183', 'status' => 1],
            [ 'country_id' => 1, 'city_id' => 1, 'name_ar' => 'Gleem branch', 'name_en' => 'Gleem branch', 'phone' => '910-886-5568', 'address' => '352 Army Road in front of Ibn El Balad', 'working_time' => 'From 11 am to 9:00 pm Friday from 2:00 pm to 9:30 pm', 'lat' => '-29.2149', 'lng' => '31.1663', 'status' => 1],
            [ 'country_id' => 1, 'city_id' => 3, 'name_ar' => 'Gleem branch', 'name_en' => 'Gleem branch', 'phone' => '411-315-3557', 'address' => '352 Army Road in front of Ibn El Balad', 'working_time' => 'From 11 am to 9:00 pm Friday from 2:00 pm to 9:30 pm', 'lat' => '63.6215', 'lng' => '54.1409', 'status' => 1],
            [ 'country_id' => 1, 'city_id' => 3, 'name_ar' => 'Al-Thawra branch', 'name_en' => 'Al-Thawra branch', 'phone' => '585-484-6971', 'address' => 'Al-Thawra Street, next to Al-Tarshoubi Pharmacy - Al-Sikka Al-Jadeeda', 'working_time' => 'From 11 to 10 (Sunday off) Friday from 2 to 10', 'lat' => '-31.5863', 'lng' => '-97.2215', 'status' => 1],
            [ 'country_id' => 1, 'city_id' => 4, 'name_ar' => 'Al-Thawra branch', 'name_en' => 'Al-Thawra branch', 'phone' => '762-587-6739', 'address' => 'Al-Thawra Street, next to Al-Tarshoubi Pharmacy - Al-Sikka Al-Jadeeda', 'working_time' => 'From 11 to 10 (Sunday off) Friday from 2 to 10', 'lat' => '53.5979', 'lng' => '106.6070', 'status' => 1],
        ];
        foreach ($branches as $branch){
            Branch::create($branch);
        }
    }
}
