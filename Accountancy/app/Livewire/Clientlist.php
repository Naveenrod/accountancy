<?php

namespace App\Livewire;

use App\Models\Client;
use App\Services\Accounting\AccountingProviders;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Clientlist extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public $message = null;

    public function mount()
    {
        $this->message = session('message');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function pushContact($clientId, $service, AccountingProviders $providers)
    {
        [$client, $sync] = $this->findSync($clientId, $service, $providers);
        $result = $providers->get($service)->pushContact($client);

        $sync->status = $result->successful ? 'Completed' : 'Failed';
        $sync->last_synced_at = now();
        $sync->save();
        $this->message = $result->message;
    }

    public function pullFinancials($clientId, $service, AccountingProviders $providers)
    {
        [$client, $sync] = $this->findSync($clientId, $service, $providers);
        $result = $providers->get($service)->pullFinancials($client);

        if ($result->successful) {
            $sync->invoice_count = $result->data['invoices'];
            $sync->balance = $result->data['balance'];
            $sync->last_synced_at = now();
            $sync->save();
        }
        $this->message = $result->message;
    }

    public function delete($clientId)
    {
        $client = Client::find($clientId);
        abort_unless($client, 404);

        $client->delete();

        $this->message = "{$client->name} deleted.";
    }

    private function findSync($clientId, $service, AccountingProviders $providers)
    {
        abort_unless($providers->has($service), 404);

        $client = Client::with('syncs')->find($clientId);
        abort_unless($client, 404);

        return [$client, $client->syncFor($service)];
    }

    public function render(AccountingProviders $providers)
    {
        $clients = Client::with('syncs')
            ->when($this->search, fn ($query) => $query->where(fn ($query) => $query
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")))
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.clientlist', [
            'clients' => $clients,
            'services' => $providers->names(),
        ])->layout('livewire.app-layout');
    }
}
