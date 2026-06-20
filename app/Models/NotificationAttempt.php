<?php

namespace App\Models;

use App\Enums\NotificationStatus;
use Illuminate\Database\Eloquent\Model;

class NotificationAttempt extends Model
{
    protected $fillable = [
        'notification_id',
        'attempt_number',
        'status',
        'error_message',
        'attempted_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => NotificationStatus::class,
            'attempted_at' => 'datetime',
        ];
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
