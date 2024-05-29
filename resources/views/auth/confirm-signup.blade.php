<x-filament-panels::page.simple heading="" class="auth-page w-screen h-dvh">
    <div class="grid md:grid-cols-2 h-full w-full">

        @livewire(App\Livewire\AuthImage::class, ['quote' => $quote])

        <div class="flex flex-row justify-center self-center">
            <x-filament-panels::form wire:submit.prevent="completeSignup" class="sm:w-4/5 md:w-3/5">
                <x-filament-panels::header heading="Personalize Your Brand" />

                {{ $this->form }}

                <x-filament::button type="submit" variant="primary" :form="$this->form" wire:target="completeSignup">
                    Complete Signup
                </x-filament::button>
                <span class="text-xs hover:cursor-pointer flex justify-around" wire:click="completeSignup">I'll set this
                    up later</span>
            </x-filament-panels::form>
        </div>

    </div>
</x-filament-panels::page.simple>
