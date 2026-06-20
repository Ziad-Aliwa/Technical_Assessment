<?php

namespace App\Enums;

enum NotificationChannel: string
{
    case EMAIL = 'Email';

    case SLACK = 'Slack';
}
