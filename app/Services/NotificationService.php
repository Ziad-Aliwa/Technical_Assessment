<?php

namespace App\Services;

use App\Enums\NotificationStatus;
use App\Models\Notification;
use App\Models\NotificationAttempt;

class NotificationService
{
    /**
     * Create notification record.
     */
    public function createNotification(array $data): Notification
    {
        return Notification::create($data);
    }

    /**
     * Create notification attempt.
     */
    public function createAttempt(
        Notification $notification,
        int $attemptNumber,
        NotificationStatus $status,
        ?string $errorMessage = null
    ): NotificationAttempt {
        return $notification->attempts()->create([
            'attempt_number' => $attemptNumber,
            'status' => $status,
            'error_message' => $errorMessage,
            'attempted_at' => now(),
        ]);
    }

    /**
     * Mark notification as successfully sent.
     */
    public function markAsSuccess(Notification $notification): void
    {
        $notification->update([
            'status' => NotificationStatus::SUCCESS,
            'sent_at' => now(),
            'error_message' => null,
        ]);
    }

    /**
     * Mark notification as failed.
     */
    public function markAsFailed(
        Notification $notification,
        string $errorMessage
    ): void {
        $notification->update([
            'status' => NotificationStatus::FAILED,
            'error_message' => $errorMessage,
        ]);
    }
}
