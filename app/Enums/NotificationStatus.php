<?php

namespace App\Enums;

enum NotificationStatus: string
{
    case PENDING = 'Pending';

    case SUCCESS = 'Success';

    case FAILED = 'Failed';
}
