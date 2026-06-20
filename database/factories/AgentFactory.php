<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'department' => fake()->randomElement([
                'Technical Support',
                'Customer Service',
                'Billing',
            ]),

            'is_active' => true,
        ];
    }
}
