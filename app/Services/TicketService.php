<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketService
{
    public function __construct(
        protected EscalationService $escalationService
    ) {}

    public function escalate(int $ticketId): Ticket
    {
        $ticket = Ticket::find($ticketId);

        if (! $ticket) {
            throw new ModelNotFoundException('Ticket not found.');
        }

        if ($ticket->status === TicketStatus::ESCALATED) {
            throw new \Exception('Ticket is already escalated.');
        }

        return $this->escalationService->escalate($ticket);
    }
}
