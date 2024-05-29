<?php

namespace App\Livewire;

use Livewire\Component;

class AuthImage extends Component
{
    public $quote;
    public function render()
    {
        return view('livewire.auth-image');
    }
}
