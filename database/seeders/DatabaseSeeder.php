<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\AddressSeeder;
use Database\Seeders\CarTypeSeeder;
use Database\Seeders\ContainerSeeder;
use Database\Seeders\OrderSettingSeeder;
use Database\Seeders\RightUseSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\TestUserSeeder;
use Database\Seeders\TaxSeeder;
use Database\Seeders\CountrySeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call([
        AddressSeeder::class,
        CarTypeSeeder::class,
        ContainerSeeder::class,
        OrderSettingSeeder::class,
        RightUseSeeder::class,
        RolesAndPermissionsSeeder::class,
        TestUserSeeder::class,
        TaxSeeder::class,
        CountrySeeder::class
      ]);
    }
}
