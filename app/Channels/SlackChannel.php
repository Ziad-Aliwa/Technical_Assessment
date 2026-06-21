<?php

namespace App\Channels;

use App\Contracts\NotificationChannelContract;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class SlackChannel implements NotificationChannelContract
{
    public function send(Notification $notification): void
    {
        /*
        |--------------------------------------------------------------------------
        | Simulation
        |--------------------------------------------------------------------------
        |
        | Uncomment the exception below to simulate
        | Slack webhook failure and test retries.
        |
        */

        // throw new \Exception('Slack webhook failed.');

        Log::info('Slack notification sent.', [
            'notification_id' => $notification->id,
            'ticket_id' => $notification->ticket_id,
            'channel' => 'Slack',
        ]);
    }
}
