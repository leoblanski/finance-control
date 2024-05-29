@php
    $isAdminPanel = filament()->getCurrentPanel()->getId() == 'admin';
@endphp

<x-filament-panels::page.simple heading="" class="auth-page w-screen h-dvh">
    <div class="grid md:grid-cols-2 h-full w-full">

        <div class="flex flex-col gap-10 self-center items-center">
            @if (filament()->hasRegistration() && !$isAdminPanel)
                <x-slot name="subheading">
                    {{ __('filament-panels::pages/auth/login.actions.register.before') }}

                    {{ $this->registerAction }}
                </x-slot>
            @endif

            @if (session()->has('message'))
                <x-filament-forms::field-wrapper.error-message>
                    {{ session('message') }}
                </x-filament-forms::field-wrapper.error-message>
            @endif

            @if ($error = request()->get('error'))
                <x-filament-forms::field-wrapper.error-message>
                    {{ $error }}
                </x-filament-forms::field-wrapper.error-message>
            @endif

            {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.before') }}

            <x-filament-panels::form wire:submit="authenticate" class="sm:w-4/5 md:w-3/5">
                <h1 class="items-start self-start text-gray-950 dark:text-white">
                    {{ $isAdminPanel ? 'Login Into Admin Panel' : 'Login Into Your Account' }}</h1>
                {{ $this->form }}

                <div class="flex justify-between items-center">
                    <x-filament::button type="submit" class=" w-2/5" :form="$this->form" wire:target="authenticate">
                        Sign In
                    </x-filament::button>
                    @if (!$isAdminPanel)
                        <a href="{{ filament()->getRequestPasswordResetUrl() }}" color="black"
                            class="text-black underline dark:text-white">
                            {{ __('filament-panels::pages/auth/login.actions.request_password_reset.label') }}
                        </a>
                    @endif
                </div>
            </x-filament-panels::form>

            <footer class="mt-10 flex gap-7 sm:w-4/5 md:w-3/5 hidden"> {{-- hidden until Paul send us info --}}
                <a href="#" class="underline">Need Help</a>
                <a href="#" class="underline">Privacy Policy</a>
            </footer>

        </div>

        @livewire(App\Livewire\AuthImage::class, ['quote' => $quote])
    </div>
</x-filament-panels::page.simple>
