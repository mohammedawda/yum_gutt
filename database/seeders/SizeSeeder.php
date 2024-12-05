<?php

namespace Database\Seeders;

use getways\cities\models\City;
use getways\products\models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Size::create([
            'name' => [
                'en' => 'small',
                'ar' => 'حجم صغير'
            ],
            'category_id'=>1
        ]);
        Size::create([
            'name' => [
                    'en' => 'medium',
                    'ar' => 'حجم متوسط'
                ],
            'category_id'=>1
        ]);
        Size::create([
            'name' => [
                    'en' => 'big',
                    'ar' => 'حجم كبير'
                ],
            'category_id'=>1
        ]);
        Size::create([
            'name' => [
                    'en' => 'family',
                    'ar' => 'حجم عائلى'
                ],
            'category_id'=>1
        ]);
    }
}
