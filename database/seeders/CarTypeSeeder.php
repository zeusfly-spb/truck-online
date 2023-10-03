<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarType;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      CarType::create([
        'name' => 'Тягач',
      ]);
      CarType::create([
        'name' => 'Полуприцеп',
      ]);
      CarType::create([
        'name' => 'Прицеп',
      ]);
    }
}
