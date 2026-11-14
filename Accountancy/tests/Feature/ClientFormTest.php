<?php

namespace Tests\Feature;

use App\Livewire\ClientForm;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ClientFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_client_can_be_added(): void
    {
        Livewire::test(ClientForm::class)
            ->set('name', 'Acme Corp')
            ->set('email', 'hello@acme.test')
            ->call('save')
            ->assertRedirect(route('clientlist'));

        $this->assertDatabaseHas('clients', ['name' => 'Acme Corp', 'email' => 'hello@acme.test']);
    }

    public function test_a_client_can_be_edited(): void
    {
        $client = Client::factory()->create(['email' => 'hello@acme.test']);

        Livewire::test(ClientForm::class, ['clientId' => $client->id])
            ->assertSet('email', 'hello@acme.test')
            ->set('name', 'Acme Ltd')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('Acme Ltd', $client->fresh()->name);
    }

    public function test_name_and_a_valid_email_are_required(): void
    {
        Livewire::test(ClientForm::class)
            ->set('email', 'not-an-email')
            ->call('save')
            ->assertHasErrors(['name' => 'required', 'email' => 'email']);
    }

    public function test_email_must_be_unique(): void
    {
        Client::factory()->create(['email' => 'hello@acme.test']);

        Livewire::test(ClientForm::class)
            ->set('name', 'Another Acme')
            ->set('email', 'hello@acme.test')
            ->call('save')
            ->assertHasErrors(['email' => 'unique']);
    }
}
