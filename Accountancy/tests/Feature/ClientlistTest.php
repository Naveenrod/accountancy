<?php

namespace Tests\Feature;

use App\Livewire\Clientlist;
use Livewire\Livewire;
use Tests\TestCase;

class ClientlistTest extends TestCase
{
    public function test_pushing_a_contact_marks_the_service_completed(): void
    {
        Livewire::test(Clientlist::class)
            ->assertSet('clients.0.xero', 'Not Started')
            ->call('pushContact', 1, 'xero')
            ->assertSet('clients.0.xero', 'Completed')
            ->assertSee('Acme Corp pushed to Xero as a contact (placeholder).');
    }

    public function test_pulling_financials_stores_invoices_and_balance(): void
    {
        Livewire::test(Clientlist::class)
            ->call('pullFinancials', 2, 'sage')
            ->assertSet('clients.1.financials.sage', ['invoices' => 3, 'balance' => 275.0])
            ->assertSee('3 invoices');
    }

    public function test_unknown_service_is_rejected(): void
    {
        Livewire::test(Clientlist::class)
            ->call('pushContact', 1, 'name')
            ->assertNotFound();
    }

    public function test_unknown_client_is_rejected(): void
    {
        Livewire::test(Clientlist::class)
            ->call('pushContact', 999, 'xero')
            ->assertNotFound();
    }
}
