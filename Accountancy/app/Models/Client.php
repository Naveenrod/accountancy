<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function syncs(): HasMany
    {
        return $this->hasMany(ClientSync::class);
    }

    /**
     * The client's sync record for a service, or an unsaved one if it has never been synced.
     */
    public function syncFor(string $service): ClientSync
    {
        return $this->syncs->firstWhere('service', $service)
            ?? new ClientSync(['client_id' => $this->id, 'service' => $service]);
    }
}
