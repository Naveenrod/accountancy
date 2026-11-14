<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientSync extends Model
{
    protected $fillable = ['client_id', 'service', 'status', 'invoice_count', 'balance', 'last_synced_at'];

    protected $attributes = ['status' => 'Not Started'];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'last_synced_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
