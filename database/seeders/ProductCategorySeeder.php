<?php

namespace Database\Seeders;

use getways\products\models\ProductCategory;
use getways\products\models\Size;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ProductCategory::create([
                'name' => [
                    'en' => 'chicken burger',
                    'ar' => 'برجر دجاج'
                ],
                'category_id'=>1
            ]);
        ProductCategory::create([
                'name' => [
                    'en' => 'beef burger',
                    'ar' => 'برجر لحم البقر'
                ],
                'category_id'=>1
            ]);
        ProductCategory::create([
                'name' => [
                    'en' => 'pasta white sauce',
                    'ar' => 'المعكرونة بالصلصة البيضاء'
                ],
                'category_id'=>1
            ]);
    }
}
