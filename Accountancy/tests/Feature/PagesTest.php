<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads(): void
    {
        $this->get('/')->assertOk()->assertSee('View clients');
    }

    public function test_client_list_loads(): void
    {
        Client::factory()->create(['name' => 'Acme Corp']);

        $this->get('/clients')->assertOk()->assertSee('Acme Corp')->assertSee('QuickBooks');
    }

    public function test_client_forms_load(): void
    {
        $client = Client::factory()->create(['name' => 'Acme Corp']);

        $this->get('/clients/create')->assertOk()->assertSee('Add client');
        $this->get("/clients/{$client->id}/edit")->assertOk()->assertSee('Edit Acme Corp');
        $this->get('/clients/999/edit')->assertNotFound();
    }
}
