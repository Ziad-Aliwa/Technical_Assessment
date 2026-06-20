<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'Open';

    case IN_PROGRESS = 'In Progress';

    case ESCALATED = 'Escalated';

    case RESOLVED = 'Resolved';

    case CLOSED = 'Closed';
}
