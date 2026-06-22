<?php

namespace Tests\Feature;

use App\Models\Ticket;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_get_all_tickets(): void
    {
        Ticket::factory()->count(3)->create();

        $response = $this->getJson('/api/tickets');

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Tickets retrieved successfully.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'timestamp',
            ]);

        $this->assertCount(
            3,
            $response->json('data')
        );
    }

    #[Test]
    public function it_can_get_single_ticket(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->getJson(
            "/api/tickets/{$ticket->id}"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Ticket retrieved successfully.',
            ])
            ->assertJsonPath(
                'data.id',
                $ticket->id
            )
            ->assertJsonPath(
                'data.subject',
                $ticket->subject
            );
    }

    #[Test]
    public function it_returns_404_when_ticket_does_not_exist(): void
    {
        $response = $this->getJson(
            '/api/tickets/999999'
        );

        $response->assertNotFound();
    }

    #[Test]
    public function tickets_endpoint_returns_expected_structure(): void
    {
        Ticket::factory()->create();

        $response = $this->getJson('/api/tickets');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',

                'data' => [
                    '*' => [
                        'id',
                        'subject',
                        'description',
                        'priority',
                        'status',
                        'escalated_at',
                        'customer',
                        'agent',
                    ]
                ],

                'timestamp',
            ]);
    }

    #[Test]
    public function ticket_show_endpoint_returns_expected_structure(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->getJson(
            "/api/tickets/{$ticket->id}"
        );

        $response
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',

                'data' => [

                    'id',
                    'subject',
                    'description',
                    'priority',
                    'status',
                    'escalated_at',

                    'customer',

                    'agent',
                ],

                'timestamp',
            ]);
    }
}
