<?php

namespace App\Listeners\Login;

class UpdateLastLogin
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->last_login_at = now();
        $event->user->save();
    }
}
