<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_homepage_loads(): void
    {
        $this->get('/')->assertOk()->assertSee('View clients');
    }

    public function test_client_list_loads(): void
    {
        $this->get('/clients')->assertOk()->assertSee('Acme Corp')->assertSee('QuickBooks');
    }
}
