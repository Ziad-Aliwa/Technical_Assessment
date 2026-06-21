<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Notification $notification
    ) {}

    public int $tries = 3;

    public function backoff(): array
    {
        return [5, 10];
    }

    public function handle(): void
    {
        //
    }

    public function failed(\Throwable $exception): void
    {
        //
    }
}