<?php

namespace App\Listeners;

use App\Events\UserSessionChanged;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BroadcastUserLoginNotification
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
    public function handle(Login $event): void
    {
        broadcast(new UserSessionChanged("{$event->user->name} is online", 'success'));
    }
}
