<?php

use App\Services\Accounting\PlaceholderProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Accounting Services
    |--------------------------------------------------------------------------
    |
    | The accounting software clients can be synced with. Each service names
    | the class that talks to it. They all use the placeholder for now; swap
    | in a real AccountingProvider implementation as each integration is built.
    |
    */

    'services' => [
        'xero' => ['name' => 'Xero', 'provider' => PlaceholderProvider::class],
        'quickbooks' => ['name' => 'QuickBooks', 'provider' => PlaceholderProvider::class],
        'sage' => ['name' => 'Sage', 'provider' => PlaceholderProvider::class],
    ],

];
