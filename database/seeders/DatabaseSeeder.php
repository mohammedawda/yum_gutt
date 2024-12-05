<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountriesSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(BranchesSeeder::class);
        $this->call(SizeSeeder::class);
    }
}
