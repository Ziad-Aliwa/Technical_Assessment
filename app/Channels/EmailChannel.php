<?php

namespace App\Channels;

use App\Contracts\NotificationChannelContract;
use App\Models\Notification;

class EmailChannel implements NotificationChannelContract
{
    public function send(Notification $notification): void
    {
        // Logic to send email notification
    }
}
