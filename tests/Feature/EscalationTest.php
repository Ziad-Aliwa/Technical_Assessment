<?php

namespace Tests\Feature;

use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EscalationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_escalate_a_ticket(): void
    {
        Queue::fake();

        $ticket = Ticket::factory()->create();

        $response = $this->postJson(
            "/api/tickets/{$ticket->id}/escalate"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Ticket escalated successfully.',
            ]);

        $ticket->refresh();

        $this->assertEquals(
            'Escalated',
            $ticket->status->value
        );

        $this->assertNotNull(
            $ticket->escalated_at
        );

        $this->assertDatabaseCount(
            'notifications',
            2
        );

        $this->assertDatabaseHas(
            'notifications',
            [
                'ticket_id' => $ticket->id,
                'channel' => 'Email',
            ]
        );

        $this->assertDatabaseHas(
            'notifications',
            [
                'ticket_id' => $ticket->id,
                'channel' => 'Slack',
            ]
        );

        Queue::assertPushed(
            SendNotificationJob::class,
            2
        );
    }

    #[Test]
    public function it_cannot_escalate_an_already_escalated_ticket(): void
    {
        Queue::fake();

        $ticket = Ticket::factory()->create([
            'status' => 'Escalated',
            'escalated_at' => now(),
        ]);

        $response = $this->postJson(
            "/api/tickets/{$ticket->id}/escalate"
        );

        $response->assertStatus(409);

        $this->assertDatabaseCount(
            'notifications',
            0
        );

        Queue::assertNothingPushed();
    }

    #[Test]
    public function it_returns_404_for_invalid_ticket(): void
    {
        Queue::fake();

        $response = $this->postJson(
            '/api/tickets/999999/escalate'
        );

        $response->assertNotFound();

        Queue::assertNothingPushed();
    }

    #[Test]
    public function escalation_creates_two_pending_notifications(): void
    {
        Queue::fake();

        $ticket = Ticket::factory()->create();

        $this->postJson(
            "/api/tickets/{$ticket->id}/escalate"
        );

        $this->assertEquals(
            2,
            Notification::count()
        );

        $this->assertDatabaseHas(
            'notifications',
            [
                'ticket_id' => $ticket->id,
                'channel' => 'Email',
                'status' => 'Pending',
            ]
        );

        $this->assertDatabaseHas(
            'notifications',
            [
                'ticket_id' => $ticket->id,
                'channel' => 'Slack',
                'status' => 'Pending',
            ]
        );
    }

    #[Test]
    public function escalation_dispatches_notification_jobs(): void
    {
        Queue::fake();

        $ticket = Ticket::factory()->create();

        $this->postJson(
            "/api/tickets/{$ticket->id}/escalate"
        );

        Queue::assertPushed(
            SendNotificationJob::class,
            2
        );
    }
}
