<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tax;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Tax::create([
        'name' => '20%',
      ]);
      Tax::create([
        'name' => 'ОСНО',
      ]);
      Tax::create([
        'name' => 'УСН',
      ]);
      Tax::create([
        'name' => 'НДС 0',
      ]);
    }
}
