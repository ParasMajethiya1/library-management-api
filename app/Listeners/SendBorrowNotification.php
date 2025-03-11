<?php

namespace App\Listeners;

use App\Events\BookBorrowed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendBorrowNotification
{
    public function handle(BookBorrowed $event)
    {
        Log::info("User {$event->user->name} borrowed book: {$event->book->title}");
    }
}
