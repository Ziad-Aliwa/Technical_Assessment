<?php

namespace App\Channels;

use App\Contracts\NotificationChannelContract;
use App\Models\Notification;

class SlackChannel implements NotificationChannelContract
{
    public function send(Notification $notification): bool
    {
        // هنكتب الكود الحقيقي بعدين

        return true;
    }
}
