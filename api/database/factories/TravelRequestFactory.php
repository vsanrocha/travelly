<?php

namespace Database\Factories;

use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelRequest>
 */
class TravelRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        $user = User::where('email', 'test@travelly.com')->first() ?? User::first();

        return [
            'user_id' => $user ? $user->id : User::factory(),
            'requester_name' => $user ? $user->name : $this->faker->name(),
            'destination' => $this->faker->city(),
            'departure_date' => $this->faker->date(),
            'return_date' => $this->faker->date(),
            'status' => 'requested',
        ];
    }
}
