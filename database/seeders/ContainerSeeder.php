<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Container;

class ContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // 20
      Container::create([
        'name' => '20 FR',
        'weight' => 20000
      ]);
      Container::create([
        'name' => '20 OT',
        'weight' => 20000
      ]);
      Container::create([
        'name' => '20 TANK',
        'weight' => 20000
      ]);
      Container::create([
        'name' => '20 DC',
        'weight' => 20000
      ]);
      Container::create([
        'name' => '20 REF',
        'weight' => 20000
      ]);
      // 40
      Container::create([
        'name' => '40 FR',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40 OT',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40 TANK',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40 DC',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40 REF',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40 HC',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '45 DC',
        'weight' => 45000
      ]);
      Container::create([
        'name' => '20+20',
        'weight' => 20000
      ]);
    }
}
