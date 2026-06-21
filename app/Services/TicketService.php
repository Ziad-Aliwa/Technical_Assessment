<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Exceptions\TicketAlreadyEscalatedException;
use App\Models\Ticket;

class TicketService
{
    public function __construct(
        protected EscalationService $escalationService
    ) {}

    public function escalate(Ticket $ticket): Ticket
    {
        if ($ticket->status === TicketStatus::ESCALATED) {
            throw new TicketAlreadyEscalatedException();
        }

        return $this->escalationService->escalate($ticket);
    }
}
