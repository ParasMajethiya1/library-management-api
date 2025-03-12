<?php

namespace App\Jobs;

use App\Models\LoginLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LoginLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $ipAddress;

    public function __construct($userId, $ipAddress)
    {
        $this->userId = $userId;
        $this->ipAddress = $ipAddress;
    }

    public function handle()
    {
        LoginLog::create([
            'user_id' => $this->userId,
            'ip_address' => $this->ipAddress,
            'logged_in_at' => now(),
        ]);
    }
}
