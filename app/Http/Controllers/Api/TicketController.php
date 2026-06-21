<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TicketService;
use App\Http\Resources\TicketResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class TicketController extends Controller
{
    public function __construct(
        protected TicketService $ticketService
    ) {}

    public function escalate(int $id)
    {
        try {

            $ticket = $this->ticketService->escalate($id);

            return response()->json([
                'success' => true,
                'message' => 'Ticket escalated successfully.',
                'data' => new TicketResource($ticket),
            ]);
        } catch (ModelNotFoundException) {

            return response()->json([
                'success' => false,
                'message' => 'Ticket not found.',
            ], 404);
        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
