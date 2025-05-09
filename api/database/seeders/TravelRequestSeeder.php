<?php

namespace Database\Seeders;

use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class TravelRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (TravelRequest::count() > 0) {
            return;
        }

        if (User::count() === 0) {
            $this->call(UserSeeder::class);
        }

        $statuses = [
            'requested',
            'approved',
            'cancelled'
        ];

        foreach ($statuses as $status) {
            TravelRequest::factory()->create([
                'status' => $status
            ]);
        }
    }
}
