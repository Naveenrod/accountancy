<?php

namespace App\Livewire;

use Livewire\Component;

class NavigatorBar extends Component
{
    public $currentPage = 'home';

    public $isOpen = true;

    public function mount()
    {
        $this->currentPage = str_starts_with(request()->route()?->getName() ?? '', 'client') ? 'clientlist' : 'home';
    }

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
