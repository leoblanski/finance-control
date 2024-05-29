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
use Illuminate\Support\Facades\Mail;
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
                Forms\Components\TextInput::make('first_name')
                    ->label('First Name')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1
                    ])
                    ->required(),
                Forms\Components\TextInput::make('last_name')
                    ->label('Last Name')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1
                    ])
                    ->required(),
                $this->getEmailFormComponent()
                    ->columnSpan(2)
                    ->label('Email Address')
                    ->required(),
                $this->getPasswordFormComponent()
                    ->columnSpan(2),
                $this->getPasswordConfirmationFormComponent()
                    ->columnSpan(2)
                    ->label('Confirm Password'),
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
        $team = Team::create([
            'brand_name' => 'Company'
        ]);

        $data = $this->form->getState();
        $data['remember_token'] = $this->rememberToken;
        $data['is_active'] = true;
        $data['team_id'] = $team->id;

        $user = $this->getUserModel()::create($data)
            ->assignRole(Role::findByName(Role::MANAGER_ROLE));

        // proposal default email template
        EmailTemplate::create([
            'team_id' => $team->id,
            'name' => 'Proposal',
            'subject' => 'Your Trip Proposal',
            'category' => 'trip',
            'body' =>
            "<p>Your new proposal for %|trip.title|% is ready. If you have any questions or changes, just let me know.<br><br><a href='" .
                env('APP_URL') .
                "proposals/%|proposal.url|%'>View Proposal</a></p>",
            'is_active' => true,
        ]);

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
