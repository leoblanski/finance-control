<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && !$request->user()->active) {
            $request->session()->invalidate();

            Notification::make()
                ->title(__('Your account is currently inactive!'))
                ->body(__('Please get in touch with the systems administrator to reactivate your account.'))
                ->danger()
                ->send();

            return redirect()->route('filament.user.auth.login');
        }

        return $next($request);
    }
}
