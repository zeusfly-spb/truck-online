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
        'name' => '20FR',
        'weight' => 20000
      ]);
      Container::create([
        'name' => '20OT',
        'weight' => 20000
      ]);
      Container::create([
        'name' => '20TANK',
        'weight' => 20000
      ]);
      Container::create([
        'name' => '20DC',
        'weight' => 20000
      ]);
      Container::create([
        'name' => '20REF',
        'weight' => 20000
      ]);
      // 40
      Container::create([
        'name' => '40FR',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40OT',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40TANK',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40DC',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40REF',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '40HC',
        'weight' => 40000
      ]);
      Container::create([
        'name' => '45DC',
        'weight' => 45000
      ]);
      Container::create([
        'name' => '20+20',
        'weight' => 20000
      ]);
    }
}
