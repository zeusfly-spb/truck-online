<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderSetting;

class OrderSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      OrderSetting::create([
        'default_over_weight_price' => 1900,
        'default_car_price' => 22750,
        'default_distance' => 117,
      ]);
    }
}
