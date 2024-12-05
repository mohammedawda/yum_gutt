<?php

namespace Database\Seeders;

use getways\products\models\Category;
use getways\products\models\Size;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::create([
                'name' => [
                    'en' => 'restaurant',
                    'ar' => 'مطعم'
                ],
            ]);
        Category::create([
                'name' => [
                    'en' => "Men's clothing",
                    'ar' => 'ملابس رجالى'
                ],
            ]);
        Category::create([
                'name' => [
                    'en' => "Women's clothing",
                    'ar' => 'ملابس حريمى'
                ],
            ]);
    }
}
