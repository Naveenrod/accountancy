<?php

namespace App\Livewire;

use App\Services\Accounting\AccountingProviders;
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

    public $message = null;

    public function pushContact($clientId, $service, AccountingProviders $providers)
    {
        $index = $this->findClient($clientId, $service, $providers);
        $result = $providers->get($service)->pushContact($this->clients[$index]);

        $this->clients[$index][$service] = $result->successful ? 'Completed' : 'Failed';
        $this->message = $result->message;
    }

    public function pullFinancials($clientId, $service, AccountingProviders $providers)
    {
        $index = $this->findClient($clientId, $service, $providers);
        $result = $providers->get($service)->pullFinancials($this->clients[$index]);

        if ($result->successful) {
            $this->clients[$index]['financials'][$service] = $result->data;
        }
        $this->message = $result->message;
    }

    private function findClient($clientId, $service, AccountingProviders $providers)
    {
        $index = array_search($clientId, array_column($this->clients, 'id'));

        abort_if($index === false || ! $providers->has($service), 404);

        return $index;
    }

    public function render(AccountingProviders $providers)
    {
        return view('livewire.clientlist', ['services' => $providers->names()])->layout('livewire.app-layout');
    }
}
