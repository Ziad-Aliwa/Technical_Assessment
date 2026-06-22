<?php

namespace App\Jobs;

use App\Contracts\NotificationChannelContract;
use App\Enums\NotificationChannel;
use App\Enums\NotificationStatus;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;
use Throwable;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Retry failed jobs 3 times.
     */
    public int $tries = 3;

    /**
     * Delay between retries.
     */
    public function backoff(): array
    {
        return [5, 10];
    }

    public function __construct(
        public int $notificationId
    ) {}

    public function handle(NotificationService $notificationService): void
    {
        $notification = Notification::with('ticket')->findOrFail($this->notificationId);

        $driver = $this->resolveChannel(
            $notification->channel
        );

        try {

            $driver->send($notification);

            $notificationService->createAttempt(
                notification: $notification,
                attemptNumber: $this->attempts(),
                status: NotificationStatus::SUCCESS
            );

            $notificationService->markAsSuccess($notification);
        } catch (Throwable $e) {

            $notificationService->createAttempt(
                notification: $notification,
                attemptNumber: $this->attempts(),
                status: NotificationStatus::FAILED,
                errorMessage: $e->getMessage()
            );

            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        $notification = Notification::with('ticket')->find($this->notificationId);

        if (! $notification) {
            return;
        }

        app(NotificationService::class)
            ->markAsFailed(
                $notification,
                $exception->getMessage()
            );
    }

    private function resolveChannel(
        NotificationChannel $channel
    ): NotificationChannelContract {

        $class = config('notifications.channels')[$channel->value] ?? null;

        if (!$class) {
            throw new InvalidArgumentException(
                "Notification channel [{$channel->value}] is not registered."
            );
        }

        return app($class);
    }
}
