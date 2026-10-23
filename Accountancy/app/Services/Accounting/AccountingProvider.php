<?php

namespace App\Services\Accounting;

use App\Models\Client;

interface AccountingProvider
{
    /**
     * Create or update the client as a contact in the accounting software.
     */
    public function pushContact(Client $client): SyncResult;

    /**
     * Fetch the client's invoices and outstanding balance from the accounting software.
     */
    public function pullFinancials(Client $client): SyncResult;
}
