<?php

namespace App\Livewire;

use App\Models\Client;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ClientForm extends Component
{
    public ?Client $client = null;

    public $name = '';

    public $email = '';

    public function mount($clientId = null)
    {
        if ($clientId) {
            $this->client = Client::findOrFail($clientId);
            $this->name = $this->client->name;
            $this->email = $this->client->email;
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('clients')->ignore($this->client)],
        ]);

        if ($this->client) {
            $this->client->update($validated);
            session()->flash('message', "{$this->client->name} updated.");
        } else {
            $client = Client::create($validated);
            session()->flash('message', "{$client->name} added.");
        }

        return redirect()->route('clientlist');
    }

    public function render()
    {
        return view('livewire.client-form')->layout('livewire.app-layout');
    }
}
