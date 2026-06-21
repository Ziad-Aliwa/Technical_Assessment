<?php

namespace App\Services;

use App\Channels\EmailChannel;
use App\Channels\SlackChannel;
use App\Enums\NotificationChannel;
use App\Models\Notification;
use App\Models\Ticket;

class NotificationManager
{
    public function __construct(
        protected EmailChannel $emailChannel,
        protected SlackChannel $slackChannel,
    ) {}
}
