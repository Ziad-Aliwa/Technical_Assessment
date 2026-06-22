<?php

namespace Database\Factories;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Agent;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [

            'customer_id' => Customer::factory(),

            'agent_id' => Agent::factory(),

            'subject' => fake()->sentence(),

            'description' => fake()->paragraph(),

            'priority' => fake()->randomElement(TicketPriority::cases())->value,

            'status' => TicketStatus::OPEN,

            'escalated_at' => null,
        ];
    }
}
