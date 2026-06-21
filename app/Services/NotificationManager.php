<?php

namespace App\Services;

use App\Enums\NotificationChannel;
use App\Enums\NotificationStatus;
use App\Jobs\SendNotificationJob;
use App\Models\Ticket;

class NotificationManager
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function send(Ticket $ticket): void
    {
        foreach (config('notifications.channels') as $channel => $class) {

            $notification = $this->notificationService->createNotification([
                'ticket_id' => $ticket->id,
                'channel' => NotificationChannel::from($channel),
                'status' => NotificationStatus::PENDING,
            ]);

            SendNotificationJob::dispatch($notification->id);
        }
    }
}