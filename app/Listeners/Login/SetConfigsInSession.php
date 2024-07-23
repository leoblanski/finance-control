<?php

namespace App\Listeners\Login;

use Illuminate\Support\Facades\Session;

class SetConfigsInSession
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // $team = $event->user->team;

        // Session::put('team_id', $event->user->team_id);
    }
}
