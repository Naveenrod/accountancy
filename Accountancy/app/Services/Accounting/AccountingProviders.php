<?php

namespace App\Services\Accounting;

use InvalidArgumentException;

class AccountingProviders
{
    /**
     * Services the app can sync with, keyed by the name used in client data.
     */
    public function names(): array
    {
        return array_map(fn ($service) => $service['name'], config('accounting.services'));
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, config('accounting.services'));
    }

    public function get(string $key): AccountingProvider
    {
        if (! $this->has($key)) {
            throw new InvalidArgumentException("Unknown accounting service [{$key}].");
        }

        $service = config("accounting.services.{$key}");

        return app()->make($service['provider'], ['name' => $service['name']]);
    }
}
