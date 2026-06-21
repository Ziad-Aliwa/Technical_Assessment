<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;




Route::post('/tickets/{ticket}/escalate', [TicketController::class, 'escalate']);
