<?php

namespace App\Livewire\Pages\Auth;

use App\Entities\Customer;
use App\Filament\User\Resources\UserResource;
use Filament\Forms;
use Filament\Pages\Page;
use App\Models\User;
use Filament\Notifications\Notification;
use App\Services\AuthQuoteService;
use App\Services\USAePayBillingService;

class ConfirmSignup extends Page
{
    protected static string $resource = UserResource::class;
    protected static string $view = 'auth.confirm-signup';
    protected static string $layout = 'auth.layout';
    public $data = [];

    public bool $confirming = false;

    public array $quote = [];

    public string $email;
    public string $token;

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->label('Company Name'),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Company Phone Number')
                    ->mask('(999) 999-9999'),
                Forms\Components\FileUpload::make('logo')
                    ->label('Upload your company logo')
                    ->disk('s3')
                    ->directory('brand-logos')
                    ->imageEditor()
                    ->imageEditorViewportWidth('1920')
                    ->imageEditorViewportHeight('500'),
                Forms\Components\FileUpload::make('avatar')
                    ->label('Upload a profile photo')
                    ->disk('s3')
                    ->visibility('public')
                    ->directory('profile_image')
                    ->imageEditor(),
            ])
            ->statePath('data');
    }

    public function mount()
    {
        $this->email = request()->email;
        $this->token = request()->token;
        $user = User::where('email', $this->email)->where('remember_token', $this->token)->firstOrFail();
        $this->quote = (new AuthQuoteService())->getQuote();

        auth()->login($user);

        Notification::make()
            ->title('Success')
            ->success()
            ->body('Account created successfully!')
            ->send()
            ->seconds(15);
    }

    public function completeSignup()
    {
        $data = $this->form->getState();
        $data['remember_token'] = null;
        $user = User::where('email', $this->email)->firstOrFail();

        $user->update([
            'is_active' => true,
            'phone_number' => $data['phone_number'],
            'avatar' => $data['avatar'],
            'email_verified_at' => now(),
        ]);

        $user->team->update([
            'brand_name' => $data['company_name'] != '' ? $data['company_name'] : 'Company',
            'brand_logo' => $data['logo'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'brand_primary_color' => '#7104ed',
            'brand_secondary_color' => '#ffffff',
        ]);

        $customerUSAePay = new Customer();
        $customerUSAePay->setFirstName($user->first_name)
            ->setLastName($user->last_name)
            ->setCompany($user->team->brand_name)
            ->setEmail($user->email)
            ->setPhone($user->phone_number ?? '');

        app(USAePayBillingService::class)->createCustomer($customerUSAePay);

        Notification::make()
            ->title('Success')
            ->success()
            ->body('Setup finished successfully!')
            ->seconds(15)
            ->send();

        return redirect('/');
    }

    public function getImageCrop(): float
    {
        return 1;
    }

    public function hasLogo()
    {
        return false;
    }

    public function getHeader(): ?\Illuminate\Contracts\View\View
    {
        return null;
    }
}
