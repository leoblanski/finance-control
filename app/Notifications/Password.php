<?php

namespace App\Notifications;

use App\Models\Role;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Notifications\Auth\ResetPassword;

class Password extends ResetPassword
{
    /**
     * @var User
     */
    private User $user;

    /**
     * @var string $url
     */
    public string $url;

    /**
     * Create a notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct(app('auth.password.broker')->createToken($user));

        $this->user = $user;
        $this->url = Filament::getPanel('users')->getResetPasswordUrl($this->token, $this->user);
    }

    /**
     * Get the notification for creating a password.
     *
     */
    public function get()
    {
        $this->buildMailMessage($this->url);
    }
}
