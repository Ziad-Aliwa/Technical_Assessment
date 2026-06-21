<?php

namespace App\Services;

use App\Contracts\NotificationChannelContract;
use App\Enums\NotificationChannel;
use App\Enums\NotificationStatus;
use App\Models\Notification;
use App\Models\Ticket;
use InvalidArgumentException;

class NotificationManager
{
    /**
     * Create notification records and dispatch them.
     */
    public function send(Ticket $ticket, array $channels): void
    {
        foreach ($channels as $channel) {

            $notification = Notification::create([
                'ticket_id' => $ticket->id,
                'channel' => $channel,
                'status' => NotificationStatus::PENDING,
            ]);

            $driver = $this->resolveChannel($channel);

            // Job here
            

            $driver->send($notification);
        }
    }

    /**
     * Resolve the notification channel from config.
     */
    private function resolveChannel(NotificationChannel $channel): NotificationChannelContract
    {
        $class = config('notifications.channels')[$channel->value] ?? null;

        if (!$class) {
            throw new InvalidArgumentException(
                "Notification channel [{$channel->value}] is not registered."
            );
        }

        return app($class);
    }
}
