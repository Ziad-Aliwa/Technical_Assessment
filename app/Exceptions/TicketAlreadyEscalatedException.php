<?php

namespace App\Exceptions;

use Exception;

class TicketAlreadyEscalatedException extends Exception
{
    protected $message = 'Ticket is already escalated.';
}
