<?php

namespace App\Listeners\User;

use App\Events\UserCreated;
use App\Notifications\CreatePassword;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordCreationEmail implements ShouldQueue
{
    public function handle(UserCreated $event)
    {
        $user = $event->user;

        if ($user->remember_token !== null) {
            return;
        }

        $notification = new CreatePassword($user);
        $notification->get();

        $user->notifyNow($notification);
    }
}
