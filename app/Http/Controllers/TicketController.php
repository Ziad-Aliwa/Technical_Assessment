<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Services\TicketService;
use App\Support\ApiResponse;

class TicketController extends Controller
{
    public function __construct(
        protected TicketService $ticketService
    ) {}

    public function escalate(Ticket $ticket)
    {
        $ticket = $this->ticketService->escalate($ticket);

        return ApiResponse::success(
            new TicketResource($ticket),
            'Ticket escalated successfully.'
        );
    }
}
