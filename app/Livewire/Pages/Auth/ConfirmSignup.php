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
                Forms\Components\TextInput::make('name')
                    ->label('Nome da Loja')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('phone')
                    ->label('Contato')
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('(99) 99999-9999')
                    ->mask('(99) 99999-9999'),

                Forms\Components\ColorPicker::make('primary_color')
                    ->label('Cor Primária')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1
                    ]),

                Forms\Components\ColorPicker::make('secondary_color')
                    ->label('Cor Secundária')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1
                    ]),

                Forms\Components\FileUpload::make('logo')
                    ->label('Associe a logo da loja')
                    ->columnSpanFull()

                    // ->disk('s3')
                    ->directory('brand-logos')
                    ->imageEditor()
                    ->imageEditorViewportWidth('1920')
                    ->imageEditorViewportHeight('500'),
                // Forms\Components\FileUpload::make('avatar')
                //     ->label('Upload a profile photo')
                //     ->disk('s3')
                //     ->visibility('public')
                //     ->directory('profile_image')
                //     ->imageEditor(),
            ])
            ->statePath('data')
            ->columns([
                'default' => 1,
                'md' => 2
            ]);
    }

    public function mount()
    {
        $this->form->fill();
        $this->email = request()->email;
        $this->token = request()->token;
        $user = User::where('email', $this->email)->where('remember_token', $this->token)->firstOrFail();
        $this->quote = (new AuthQuoteService())->getQuote();
        auth()->login($user);

        Notification::make()
            ->title('Successo!')
            ->success()
            ->body('Loja criada com sucesso!')
            ->send()
            ->seconds(15);
    }

    public function completeSignup()
    {
        $data = $this->form->getState();

        $data['remember_token'] = null;
        $user = User::where('email', $this->email)->firstOrFail();

        $user->update([
            'ative' => true,
            'email_verified_at' => now(),
        ]);

        $user->brand->update([
            'name' => $data['name'] != '' ? $data['name'] : 'Loja Virtual',
            'email' => $user->email,
            'logo' => $data['logo'] ?? null,
            'phone' => $data['phone'] ?? null,
            'primary_color' => $data['primary_color'] ?? '#ef7d00',
            'secondary_color' => $data['secondary_color'] ?? '#000000',
        ]);

        // $customerUSAePay = new Customer();
        // $customerUSAePay->setFirstName($user->first_name)
        //     ->setLastName($user->last_name)
        //     ->setCompany($user->team->brand_name)
        //     ->setEmail($user->email)
        //     ->setPhone($user->phone_number ?? '');

        // app(USAePayBillingService::class)->createCustomer($customerUSAePay);

        Notification::make()
            ->title('Successo!')
            ->success()
            ->body('Loja criada com sucesso!')
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
