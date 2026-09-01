<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SiteSetting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        SiteSetting::firstOrCreate([
            'id' => 1,
        ], [
            'site_name' => 'My Shop',
            'site_email' => 'excelsiortechnology1102@gmail.com',
            'site_phone' => '7069688473',
            'site_address' => 'ZionZ1, Bodak Dev, Sindhu Bhawan Road, Ahmedabad',
        ]);
    }
}
