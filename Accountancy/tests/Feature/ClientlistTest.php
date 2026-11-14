<?php

namespace Tests\Feature;

use App\Livewire\Clientlist;
use App\Models\Client;
use Database\Seeders\ClientSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ClientlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_pushing_a_contact_marks_the_service_completed(): void
    {
        $client = Client::factory()->create(['name' => 'Acme Corp']);

        Livewire::test(Clientlist::class)
            ->call('pushContact', $client->id, 'xero')
            ->assertSee('Acme Corp pushed to Xero as a contact (placeholder).');

        $sync = $client->syncs()->where('service', 'xero')->first();
        $this->assertSame('Completed', $sync->status);
        $this->assertNotNull($sync->last_synced_at);
    }

    public function test_pulling_financials_stores_invoices_and_balance(): void
    {
        $client = Client::factory()->create(['id' => 2]);

        Livewire::test(Clientlist::class)
            ->call('pullFinancials', $client->id, 'sage')
            ->assertSee('3 invoices');

        $sync = $client->syncs()->where('service', 'sage')->first();
        $this->assertSame(3, $sync->invoice_count);
        $this->assertSame('275.00', $sync->balance);
        $this->assertSame('Not Started', $sync->status);
    }

    public function test_syncing_updates_an_existing_record(): void
    {
        $client = Client::factory()->create();
        $client->syncs()->create(['service' => 'xero', 'status' => 'Failed']);

        Livewire::test(Clientlist::class)->call('pushContact', $client->id, 'xero');

        $this->assertSame(1, $client->syncs()->count());
        $this->assertSame('Completed', $client->syncs()->first()->status);
    }

    public function test_unknown_service_is_rejected(): void
    {
        $client = Client::factory()->create();

        Livewire::test(Clientlist::class)
            ->call('pushContact', $client->id, 'name')
            ->assertNotFound();
    }

    public function test_unknown_client_is_rejected(): void
    {
        Livewire::test(Clientlist::class)
            ->call('pushContact', 999, 'xero')
            ->assertNotFound();
    }

    public function test_deleting_an_unknown_client_is_rejected(): void
    {
        Livewire::test(Clientlist::class)
            ->call('delete', 999)
            ->assertNotFound();
    }

    public function test_search_filters_by_name_or_email(): void
    {
        Client::factory()->create(['name' => 'Acme Corp', 'email' => 'hello@acme.test']);
        Client::factory()->create(['name' => 'Hooli', 'email' => 'admin@hooli.test']);

        Livewire::test(Clientlist::class)
            ->set('search', 'acme')
            ->assertSee('Acme Corp')
            ->assertDontSee('Hooli')
            ->set('search', 'admin@')
            ->assertSee('Hooli')
            ->assertDontSee('Acme Corp')
            ->set('search', 'nobody')
            ->assertSee('No clients match your search.');
    }

    public function test_clients_are_paginated(): void
    {
        $this->seed(ClientSeeder::class);

        Livewire::test(Clientlist::class)
            ->assertSee('Acme Corp')
            ->assertDontSee('Wayne Enterprises')
            ->call('nextPage')
            ->assertSee('Wayne Enterprises');
    }

    public function test_deleting_a_client_removes_it_and_its_syncs(): void
    {
        $client = Client::factory()->create(['name' => 'Acme Corp']);
        $client->syncs()->create(['service' => 'xero']);

        Livewire::test(Clientlist::class)
            ->call('delete', $client->id)
            ->assertSee('Acme Corp deleted.');

        $this->assertModelMissing($client);
        $this->assertDatabaseCount('client_syncs', 0);
    }
}
