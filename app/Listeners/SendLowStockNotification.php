<?php

namespace App\Listeners;

use App\Events\LowStockDetected;
use App\Notifications\LowStockNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendLowStockNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LowStockDetected $event): void
    {
        Notification::route('mail', 'admin@example.com')
            ->notify(new LowStockNotification($event->stock));
    }
}
