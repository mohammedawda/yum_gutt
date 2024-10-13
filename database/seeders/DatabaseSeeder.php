<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use getways\users\models\User;
use getways\users\models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountriesSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(PaymentMethodGroupSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(BranchesSeeder::class);
    }
}
