<?php

namespace App\Filament\Auth;

use App\Http\Responses\RegistrationResponse;
use App\Models\User;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\BaseMail;
use App\Models\EmailTemplate;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use App\Services\AuthQuoteService;
use Filament\Facades\Filament;
use App\Jobs\DispatchEmail;

class Register extends BaseRegister
{
    protected static string $view = 'auth.register';
    protected static string $layout = 'auth.layout';

    public array $quote = [];

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome Completo')
                    ->columnSpan([
                        'default' => 2,
                    ])
                    ->required(),
                Forms\Components\TextInput::make('username')
                    ->label('Usuário')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                    ]),
                $this->getEmailFormComponent()
                    ->columnSpan(2)
                    ->label('E-mail')
                    ->required(),
                $this->getPasswordFormComponent()
                    ->label('Senha')
                    ->columnSpan(2),
                $this->getPasswordConfirmationFormComponent()
                    ->columnSpan(2)
                    ->label('Confirmar senha'),
            ])
            ->statePath('data')
            ->columns([
                'default' => 1,
                'md' => 2
            ]);
    }

    public function mount(): void
    {
        $this->quote = (new AuthQuoteService())->getQuote();
    }

    private function createUser()
    {
        $data = $this->form->getState();

        $users = User::where('username', $data['username'])
            ->orWhere('email', $data['email'])
            ->count();

        if ($users > 0) {
            Notification::make()
                ->title('Error')
                ->danger()
                ->body('Username already exists. Please choose another one.')
                ->send();

            return null;
        }

        if ($data['username'] === null) {
            $data['username'] = $data['email'];
        }

        $team = Team::create([
            'name' => 'Controle' . $data['username'],
            'email' => $data['email'],
            'active' => true
        ]);

        $data['remember_token'] = $this->rememberToken;
        $data['active'] = true;
        $data['team_id'] = $team->id;

        $user = $this->getUserModel()::create($data);

        return $user;
    }

    public function register(): ?RegistrationResponse
    {
        $this->rememberToken = $this->generateToken();

        $user = $this->wrapInDatabaseTransaction(fn () => $this->createUser());

        $confirmUrl = route('auth.confirm-signup', [
            'email' => $user->email,
            'token' => $this->rememberToken
        ]);

        $isEmailSent = $this->sendEmail($user->email, $this->getEmailMessage($confirmUrl));

        if (!$isEmailSent) {
            return null;
        }

        Filament::auth()->login($user);
        session()->regenerate();
        request()->merge(['confirmUrl' => $confirmUrl]);

        return app(RegistrationResponse::class);
    }

    private function generateToken(): string
    {
        return sha1(uniqid('', true));
    }

    private function getEmailMessage($url)
    {
        return (new MailMessage())
            ->subject('Registration - Success')
            ->line('You are receiving this email because an account was created with your email address.')
            ->line('Your account is already active. Please click the button below if you want to customize your account.')
            ->action('Customize Account', $url);
    }

    private function sendEmail($to, $body)
    {
        try {
            DispatchEmail::dispatch([
                'to' => $to,
                'body' => $body,
                'subject' => "Registration - Success",
                'operation' => "user_registration"
            ])->onQueue('emails');

            return true;
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->danger()
                ->body('There was an error creating your account. Please try again.')
                ->send();

            // Delete newly created user to avoid orphaned records, security risks and to avoid locking the new user out of the system
            $user = User::where('email', $to)->first();
            $user->delete();

            Log::error('Error sending email: ' . $e->getMessage());

            return false;
        }
    }
}
