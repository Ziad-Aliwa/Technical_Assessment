<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory(10)->create();

        Agent::factory(5)->create();

        Ticket::factory(20)->create();
    }
}
