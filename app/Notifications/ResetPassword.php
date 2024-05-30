<?php

namespace App\Notifications;

use App\Models\User;

class ResetPassword extends Password
{
    /**
     * @var User
     */
    private User $user;

    /**
     * Create a notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
