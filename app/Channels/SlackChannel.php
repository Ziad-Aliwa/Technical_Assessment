<?php

namespace App\Channels;

use App\Contracts\NotificationChannelContract;
use App\Models\Notification;

class SlackChannel implements NotificationChannelContract
{
    public function send(Notification $notification): void
    {
        // Logic to send Slack notification
    }
}
