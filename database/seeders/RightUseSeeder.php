<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RightUse;

class RightUseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      RightUse::create([
        'name' => 'Собственность',
      ]);
      RightUse::create([
        'name' => 'Аренда',
      ]);
      RightUse::create([
        'name' => 'Лизинг',
      ]);
    }
}
