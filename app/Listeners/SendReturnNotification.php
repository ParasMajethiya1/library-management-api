<?php

namespace App\Listeners;

use App\Events\BookReturned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendReturnNotification
{
    public function handle(BookReturned $event)
    {
        Log::info("User {$event->user->name} returned book: {$event->book->title}");
    }
}
