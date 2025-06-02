<?php

namespace App\Livewire;

use Livewire\Component;

class Clientlist extends Component
{
    public $clients = [
        [
            'id' => 1,
            'name' => 'Acme Corp',
            'email' => 'contact@acmecorp.com',
            'xero' => 'Not Started',
            'quickbooks' => 'Not Started',
            'sage' => 'Not Started',
        ],
        [
            'id' => 2,
            'name' => 'Wayne Enterprises',
            'email' => 'info@wayne.com',
            'xero' => 'In Progress',
            'quickbooks' => 'Completed',
            'sage' => 'Not Started',
        ],
        [
            'id' => 3,
            'name' => 'Stark Industries',
            'email' => 'support@starkindustries.com',
            'xero' => 'Completed',
            'quickbooks' => 'In Progress',
            'sage' => 'Completed',
        ],
        [
            'id' => 4,
            'name' => 'Umbrella Corp',
            'email' => 'admin@umbrella.com',
            'xero' => 'In Progress',
            'quickbooks' => 'Not Started',
            'sage' => 'Not Started',
        ],
        [
            'id' => 5,
            'name' => 'Oscorp',
            'email' => 'contact@oscorp.com',
            'xero' => 'Completed',
            'quickbooks' => 'Not Started',
            'sage' => 'In Progress',
        ],
        [
            'id' => 6,
            'name' => 'LexCorp',
            'email' => 'info@lexcorp.com',
            'xero' => 'Not Started',
            'quickbooks' => 'Completed',
            'sage' => 'In Progress',
        ],
        [
            'id' => 7,
            'name' => 'Cyberdyne Systems',
            'email' => 'contact@cyberdyne.com',
            'xero' => 'In Progress',
            'quickbooks' => 'In Progress',
            'sage' => 'Not Started',
        ],
        [
            'id' => 8,
            'name' => 'Blue Sky Studios',
            'email' => 'support@bluesky.com',
            'xero' => 'Completed',
            'quickbooks' => 'Not Started',
            'sage' => 'In Progress',
        ],
        [
            'id' => 9,
            'name' => 'InGen',
            'email' => 'admin@ingen.com',
            'xero' => 'In Progress',
            'quickbooks' => 'Completed',
            'sage' => 'Not Started',
        ],
        [
            'id' => 10,
            'name' => 'Weyland-Yutani Corp',
            'email' => 'info@weyland.com',
            'xero' => 'Not Started',
            'quickbooks' => 'In Progress',
            'sage' => 'Completed',
        ],
        [
            'id' => 11,
            'name' => 'Tyrell Corporation',
            'email' => 'contact@tyrellcorp.com',
            'xero' => 'Completed',
            'quickbooks' => 'Completed',
            'sage' => 'Not Started',
        ],
        [
            'id' => 12,
            'name' => 'Cybertronix',
            'email' => 'support@cybertronix.com',
            'xero' => 'Not Started',
            'quickbooks' => 'In Progress',
            'sage' => 'Completed',
        ],
        [
            'id' => 13,
            'name' => 'Pied Piper',
            'email' => 'info@piedpiper.com',
            'xero' => 'In Progress',
            'quickbooks' => 'Completed',
            'sage' => 'Completed',
        ],
        [
            'id' => 14,
            'name' => 'Vandelay Industries',
            'email' => 'contact@vandelay.com',
            'xero' => 'Completed',
            'quickbooks' => 'Not Started',
            'sage' => 'In Progress',
        ],
        [
            'id' => 15,
            'name' => 'Hooli',
            'email' => 'admin@hooli.com',
            'xero' => 'Not Started',
            'quickbooks' => 'Completed',
            'sage' => 'In Progress',
        ],
    ];
    

    public function syncClient($clientId, $service)
    {
        // This is where you'd implement the actual API call to sync the client
        // For now, we'll just simulate the process
        $statuses = ['Not Started', 'In Progress', 'Completed', 'Failed'];
        $newStatus = $statuses[array_rand($statuses)];
        
        $clientIndex = array_search($clientId, array_column($this->clients, 'id'));
        $this->clients[$clientIndex][$service] = $newStatus;
    }

    public function render()
    {
        return view('livewire.clientlist')->layout('livewire.app-layout');
    }
}
