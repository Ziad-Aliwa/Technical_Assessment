<?php

use App\Channels\EmailChannel;
use App\Channels\SlackChannel;
use App\Enums\NotificationChannel;

return [

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | Register notification channels here.
    | To add a new channel:
    | 1. Create a Channel class implementing NotificationChannelContract.
    | 2. Register it below.
    |
    */

    'channels' => [

        NotificationChannel::EMAIL->value => EmailChannel::class,

        NotificationChannel::SLACK->value => SlackChannel::class,

    ],

];