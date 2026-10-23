<?php

namespace App\Services\Accounting;

class SyncResult
{
    public function __construct(
        public readonly bool $successful,
        public readonly string $message,
        public readonly array $data = [],
    ) {}

    public static function success(string $message, array $data = []): self
    {
        return new self(true, $message, $data);
    }

    public static function failure(string $message): self
    {
        return new self(false, $message);
    }
}
