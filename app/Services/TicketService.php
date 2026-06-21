<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Exceptions\TicketAlreadyEscalatedException;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;


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

    public function getAll(): Collection
    {
        return Ticket::query()
            ->with([
                'customer:id,name,email',
                'agent.user:id,name',
            ])
            ->latest()
            ->select([
                'id',
                'customer_id',
                'agent_id',
                'subject',
                'description',
                'priority',
                'status',
                'escalated_at',
                'created_at',
                'updated_at',
            ])
            ->get();
    }
}
