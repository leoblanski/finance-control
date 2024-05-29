<x-filament-panels::page.simple heading="" class="auth-page w-screen h-dvh">
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <div class="grid md:grid-cols-2 h-full w-full">
        <div class="flex flex-col gap-10 self-center items-center">
            <x-filament-panels::form wire:submit.prevent="register" class="sm:w-4/5 md:w-3/5">
                <x-filament-panels::header heading="Sign Up For Free Today" />
                {{ $this->form }}

                <x-filament::button type="submit" variant="primary" :form="$this->form" wire:target="register">
                    Start Your 30 Day Free Trial
                </x-filament::button>
                <p class="text-center text-xs">No Credit Card Required</p>
            </x-filament-panels::form>

            <footer class="mt-10 flex justify-around w-2/5 hidden"> {{-- hidden until Paul send us info --}}
                <a href="#" class="underline">Need Help</a>
                <a href="#" class="underline">Privacy Policy</a>
            </footer>
        </div>

        @livewire(App\Livewire\AuthImage::class, ['quote' => $quote])

    </div>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_REGISTER_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

</x-filament-panels::page.simple>
