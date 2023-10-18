<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      User::create(['email' => 'admin@online-port.ru', 'phone' => '5555555555', 'extension' => '1000000',
        'company_id' => 1, 'password' => bcrypt('test1234567')]);
      Artisan::call('passport:install --force');
    }
}
