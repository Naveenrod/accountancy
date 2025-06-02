<?php

namespace App\Livewire;

use Livewire\Component;

class NavigatorBar extends Component
{
    public $currentPage = 'home';

    public $isOpen = true;

    public function setPage($page)
    {
        $this->currentPage = $page;
        return redirect()->route($page);
    }

    public function toggleMenu()
    {
        $this->isOpen = !$this->isOpen;
    }
    
    public function render()
    {
        return view('livewire.navigator-bar');
    }
}
