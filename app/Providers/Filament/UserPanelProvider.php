<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Login;
use App\Filament\Auth\PasswordReset\RequestPasswordReset;
use App\Filament\Auth\Register;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('user')
            ->path('/')
            ->login(
                Login::class,
            )
            ->font('Nexa')
            ->registration(Register::class)
            ->registrationRouteSlug('signup')
            ->passwordReset(
                RequestPasswordReset::class
            )
            ->colors([
                'primary' =>  [
                    50 => '255, 247, 237',    // Lighter
                    100 => '255, 237, 213',   // Lighter
                    200 => '254, 215, 170',   // Lighter
                    300 => '253, 186, 116',   // Lighter
                    400 => '251, 146, 60',    // Lighter
                    500 => '249, 115, 22',    // Base color: slightly lighter than the original #ef7d00
                    600 => '234, 88, 12',     // Darker
                    700 => '194, 65, 12',     // Darker
                    800 => '154, 52, 18',     // Darker
                    900 => '124, 45, 18',     // Darker
                    950 => '67, 20, 7',       // Darkest
                ]
            ])
            ->globalSearch(true)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/app.css');
    }
}
