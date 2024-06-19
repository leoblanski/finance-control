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
        $brand = $event->user->brand;

        Session::put('brand_id', $event->user->brand_id);
    }
}
