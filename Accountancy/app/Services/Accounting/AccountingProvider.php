<?php

namespace App\Services\Accounting;

interface AccountingProvider
{
    /**
     * Create or update the client as a contact in the accounting software.
     */
    public function pushContact(array $client): SyncResult;

    /**
     * Fetch the client's invoices and outstanding balance from the accounting software.
     */
    public function pullFinancials(array $client): SyncResult;
}
