<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;




Route::prefix('tickets')->group(function () {

    Route::get('/', [TicketController::class, 'index']);

    Route::get('{ticket}', [TicketController::class, 'show']);

    Route::post('{ticket}/escalate', [TicketController::class, 'escalate']);
});
