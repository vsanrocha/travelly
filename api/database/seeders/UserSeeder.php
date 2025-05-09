<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'test@travelly.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@travelly.com',
                'password' => bcrypt('123456'),
            ]);
        }
    }
}
