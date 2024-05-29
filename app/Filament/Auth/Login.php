<?php

namespace App\Filament\Auth;

use Blade;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use App\Services\AuthQuoteService;

class Login extends BaseAuth
{
    /**
     * @var view-string
     */
    protected static string $view = 'auth.login';
    protected static string $layout = 'auth.layout';
    public array $quote = [];


    public function mount(): void
    {
        $this->quote = (new AuthQuoteService())->getQuote();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getLoginEmailFormComponent()
                    ->hint(function () {
                        if (filament()->getCurrentPanel()->getId() == 'admin') {
                            return null;
                        }

                        return new HtmlString(
                            Blade::render('
                                <span>Não possui uma conta?</span>
                                <a href="{{filament()->getRegistrationUrl()}}" color="primary" class="text-primary font-bold underline">Se cadastrar</a>
                            ')
                        );
                    }),
                $this->getPasswordFormComponent()
                    ->label('Senha')
                    ->hint(null),
                $this->getRememberFormComponent()
                    ->label('Manter conectado'),
            ])
            ->statePath('data');
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $login_type => $data['login'],
            'password' => $data['password'],
        ];
    }

    /**
     * Rewrite the authenticate method to use our custom validations
     * Authenticates the user.
     *
     * @return LoginResponse|null The login response, or null if authentication fails.
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        if (Filament::auth()->check()) {
            session()->invalidate();
        }

        if (!Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();

        if (!$user->isActive()) {
            Filament::auth()->logout();
            session()->invalidate();

            throw new \Exception('Inactive user.', 401);
        }

        if (
            ($user instanceof FilamentUser) &&
            (!$user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    protected function getLoginEmailFormComponent()
    {
        return TextInput::make('login')
            ->label('E-mail ou Usuário')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }
}
