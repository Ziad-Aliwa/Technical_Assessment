<?php

namespace Tests\Feature;

use App\Enums\NotificationChannel;
use App\Enums\NotificationStatus;
use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use App\Models\NotificationAttempt;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NotificationJobTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function notification_job_marks_notification_as_success(): void
    {
        $ticket = Ticket::factory()->create();

        $notification = Notification::create([
            'ticket_id' => $ticket->id,
            'channel' => NotificationChannel::EMAIL,
            'status' => NotificationStatus::PENDING,
        ]);

        $job = new SendNotificationJob($notification->id);

        $job->handle(app(\App\Services\NotificationService::class));

        $notification->refresh();

        $this->assertEquals(
            NotificationStatus::SUCCESS,
            $notification->status
        );

        $this->assertNotNull(
            $notification->sent_at
        );

        $this->assertDatabaseHas(
            'notification_attempts',
            [
                'notification_id' => $notification->id,
                'attempt_number' => 1,
                'status' => 'Success',
            ]
        );
    }

    #[Test]
    public function notification_attempt_is_created(): void
    {
        $ticket = Ticket::factory()->create();

        $notification = Notification::create([
            'ticket_id' => $ticket->id,
            'channel' => NotificationChannel::SLACK,
            'status' => NotificationStatus::PENDING,
        ]);

        $job = new SendNotificationJob($notification->id);

        $job->handle(app(\App\Services\NotificationService::class));

        $this->assertEquals(
            1,
            NotificationAttempt::count()
        );
    }

    #[Test]
    public function failed_method_marks_notification_as_failed(): void
    {
        $ticket = Ticket::factory()->create();

        $notification = Notification::create([
            'ticket_id' => $ticket->id,
            'channel' => NotificationChannel::EMAIL,
            'status' => NotificationStatus::PENDING,
        ]);

        $job = new SendNotificationJob($notification->id);

        $job->failed(
            new \Exception('SMTP server unavailable')
        );

        $notification->refresh();

        $this->assertEquals(
            NotificationStatus::FAILED,
            $notification->status
        );

        $this->assertEquals(
            'SMTP server unavailable',
            $notification->error_message
        );
    }

    #[Test]
    public function notification_job_creates_only_one_attempt_on_success(): void
    {
        $ticket = Ticket::factory()->create();

        $notification = Notification::create([
            'ticket_id' => $ticket->id,
            'channel' => NotificationChannel::EMAIL,
            'status' => NotificationStatus::PENDING,
        ]);

        $job = new SendNotificationJob($notification->id);

        $job->handle(app(\App\Services\NotificationService::class));

        $this->assertDatabaseCount(
            'notification_attempts',
            1
        );
    }
}
