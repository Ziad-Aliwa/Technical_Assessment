<?php

namespace App\Services;

use App\Enums\NotificationChannel;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class EscalationService
{
    public function __construct(
        protected NotificationManager $notificationManager
    ) {}

    public function escalate(Ticket $ticket): Ticket
    {
        DB::transaction(function () use ($ticket) {

            $ticket->update([
                'status' => TicketStatus::ESCALATED,
                'escalated_at' => now(),
            ]);

            $this->notificationManager->send(
                $ticket,
                [
                    NotificationChannel::EMAIL,
                    NotificationChannel::SLACK,
                ]
            );
        });

        return $ticket->fresh();
    }
}
