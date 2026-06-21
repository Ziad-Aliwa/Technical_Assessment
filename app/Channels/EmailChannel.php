<?php

namespace App\Channels;

use App\Contracts\NotificationChannelContract;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class EmailChannel implements NotificationChannelContract
{
    public function send(Notification $notification): void
    {
        /*
        |--------------------------------------------------------------------------
        | Simulation
        |--------------------------------------------------------------------------
        |
        | Uncomment the exception below to simulate
        | Email service failure and test retries.
        |
        */

        // throw new \Exception('Email service unavailable.');

        Log::info('Email notification sent.', [
            'notification_id' => $notification->id,
            'ticket_id' => $notification->ticket_id,
            'channel' => 'Email',
        ]);
    }
}
