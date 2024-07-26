<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\RegistrationResponse as AuthRegistrationResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class RegistrationResponse extends AuthRegistrationResponse
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        return redirect('/');
    }
}
