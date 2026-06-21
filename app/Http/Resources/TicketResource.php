<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'subject' => $this->subject,

            'description' => $this->description,

            'priority' => $this->priority->value,

            'status' => $this->status->value,

            'escalated_at' => $this->escalated_at?->toISOString(),

            'created_at' => $this->created_at?->toISOString(),

            'updated_at' => $this->updated_at?->toISOString(),

            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email,
            ],

            'agent' => [
                'id' => $this->agent->id,
                'name' => $this->agent->user->name,
                'department' => $this->agent->department,
            ],

        ];
    }
}
