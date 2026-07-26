<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'driver', 'api_endpoint',
        'credentials', 'is_active', 'auto_sync', 'last_synced_at',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'auto_sync'      => 'boolean',
        'last_synced_at' => 'datetime',
        // API credentials are stored encrypted and JSON-cast transparently.
        'credentials'    => 'encrypted:array',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
