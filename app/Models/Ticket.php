<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'customer_id',
        'agent_id',
        'subject',
        'description',
        'priority',
        'status',
        'escalated_at',
    ];
    protected function casts(): array
    {
        return [

            'status' => TicketStatus::class,

            'priority' => TicketPriority::class,

            'escalated_at' => 'datetime',

        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
