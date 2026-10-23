<?php

namespace App\Services\Accounting;

/**
 * Stand-in for a real Xero, QuickBooks or Sage integration. It makes no API
 * calls: pushes always succeed and pulls return made-up figures derived from
 * the client's id, so the same client always shows the same numbers.
 */
class PlaceholderProvider implements AccountingProvider
{
    public function __construct(private string $name) {}

    public function pushContact(array $client): SyncResult
    {
        return SyncResult::success("{$client['name']} pushed to {$this->name} as a contact (placeholder).");
    }

    public function pullFinancials(array $client): SyncResult
    {
        $invoices = $client['id'] % 5 + 1;
        $balance = fmod($client['id'] * 137.5, 2500);

        return SyncResult::success(
            "Pulled {$invoices} invoices for {$client['name']} from {$this->name} (placeholder).",
            ['invoices' => $invoices, 'balance' => $balance],
        );
    }
}
