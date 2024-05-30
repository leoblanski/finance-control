<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CreatePassword extends Password
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

    /**
     * Get the notification for creating a password.
     *
     */
    public function get()
    {
        $this->buildMailMessage($this->url);
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage())
            ->subject(Lang::get('Criação de senha'))
            ->line(Lang::get('Você está recebendo este e-mail porque recebemos uma solicitação de criação de senha para sua conta.'))
            ->action(Lang::get('Criar senha'), $url)
            ->line(Lang::get('Este link de criação de senha expirará em :count minutos.', [
                'count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')
            ]))
            ->line(Lang::get('Se você não solicitou uma criação de senha, nenhuma ação adicional é necessária.'));
    }
}
