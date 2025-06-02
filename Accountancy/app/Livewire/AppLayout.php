<?php

namespace App\Livewire;

use Livewire\Component;

class AppLayout extends Component
{
    public $slot;

    public function render()
    {
        return view('livewire.app-layout');
    }
}
